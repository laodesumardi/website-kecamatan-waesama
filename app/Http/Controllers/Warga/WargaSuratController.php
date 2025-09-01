<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class WargaSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get dashboard statistics
        $stats = $this->getDashboardStats();
        
        // Get recent surat for activities
        $recentSurat = Surat::with('processor')
                           ->where('nik_pemohon', $user->nik)
                           ->orderBy('created_at', 'desc')
                           ->limit(5)
                           ->get();
        
        return view('warga.surat.index', compact('stats', 'recentSurat'));
    }
    
    /**
     * Display surat list with filters
     */
    public function list(Request $request)
    {
        $user = Auth::user();
        $query = Surat::with('processor')
                     ->where('nik_pemohon', $user->nik);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('keperluan', 'like', "%{$search}%")
                  ->orWhere('jenis_surat', 'like', "%{$search}%");
            });
        }
        
        // Filter by jenis surat
        if ($request->filled('jenis_surat')) {
            $query->where('jenis_surat', $request->jenis_surat);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        $surat = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('warga.surat.list', compact('surat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $jenisSurat = $request->get('jenis_surat');
        return view('warga.surat.create', compact('jenisSurat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'jenis_surat' => 'required|in:Domisili,SKTM,Usaha,Pengantar,Kematian,Kelahiran,Pindah',
            'keperluan' => 'required|string|max:500',
            'data_tambahan' => 'nullable|array',
            'data_tambahan.*' => 'nullable|string|max:255',
        ]);
        
        // Auto-fill data from user profile
        $suratData = [
            'jenis_surat' => $validated['jenis_surat'],
            'nama_pemohon' => $user->name,
            'nik_pemohon' => $user->nik,
            'alamat_pemohon' => $user->alamat ?? '',
            'phone_pemohon' => $user->phone ?? '',
            'keperluan' => $validated['keperluan'],
            'data_tambahan' => $validated['data_tambahan'] ?? null,
            'status' => 'Pending',
            'nomor_surat' => $this->generateNomorSurat($validated['jenis_surat']),
        ];
        
        $surat = Surat::create($suratData);
        
        // Create notification for all admin users
        $adminUsers = User::whereHas('role', function($query) {
            $query->where('name', 'Admin');
        })->get();
        
        foreach ($adminUsers as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'surat_baru',
                'title' => 'Pengajuan Surat Baru',
                'message' => "Pengajuan surat {$validated['jenis_surat']} dari {$user->name} telah dibuat.",
                'priority' => 'medium',
                'data' => json_encode([
                    'surat_id' => $surat->id,
                    'jenis_surat' => $validated['jenis_surat'],
                    'nama_pemohon' => $user->name,
                    'url' => route('admin.surat.show', $surat)
                ])
            ]);
        }
        
        return redirect()->route('warga.surat.show', $surat)
                        ->with('success', 'Pengajuan surat berhasil dibuat. Silakan tunggu proses verifikasi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Surat $surat)
    {
        $user = Auth::user();
        
        // Ensure user can only view their own surat
        if ($surat->nik_pemohon !== $user->nik) {
            abort(403, 'Anda tidak memiliki akses untuk melihat surat ini.');
        }
        
        $surat->load('processor');
        return view('warga.surat.show', compact('surat'));
    }

    /**
     * Download surat file
     */
    public function download(Surat $surat)
    {
        $user = Auth::user();
        
        // Ensure user can only download their own surat
        if ($surat->nik_pemohon !== $user->nik) {
            abort(403, 'Anda tidak memiliki akses untuk mengunduh surat ini.');
        }
        
        if (!$surat->file_surat || !Storage::disk('public')->exists($surat->file_surat)) {
            return redirect()->back()->with('error', 'File surat tidak ditemukan atau belum tersedia.');
        }
        
        return Storage::disk('public')->download($surat->file_surat, $surat->nomor_surat . '.pdf');
    }

    /**
     * Generate nomor surat
     */
    private function generateNomorSurat($jenisSurat)
    {
        $prefix = match($jenisSurat) {
            'Domisili' => 'DOM',
            'SKTM' => 'SKTM',
            'Usaha' => 'USH',
            'Pengantar' => 'PNG',
            'Kematian' => 'KMT',
            'Kelahiran' => 'KLH',
            'Pindah' => 'PND',
            default => 'SRT'
        };
        
        $year = date('Y');
        $month = date('m');
        
        // Get last number for this month and year
        $lastSurat = Surat::where('nomor_surat', 'like', "{$prefix}/{$month}/{$year}/%")
                          ->orderBy('nomor_surat', 'desc')
                          ->first();
        
        $number = 1;
        if ($lastSurat) {
            $parts = explode('/', $lastSurat->nomor_surat);
            $number = (int)end($parts) + 1;
        }
        
        return sprintf('%s/%s/%s/%04d', $prefix, $month, $year, $number);
    }

    /**
     * Export surat to PDF
     */
    public function exportPdf(Surat $surat)
    {
        // Check if user owns this surat
        if ($surat->nik_pemohon !== Auth::user()->nik) {
            abort(403, 'Unauthorized access to this surat.');
        }

        $pdf = PDF::loadView('warga.surat.pdf', compact('surat'));
        return $pdf->download('surat-' . $surat->nomor_surat . '.pdf');
    }

    /**
     * Get dashboard statistics for warga
     */
    public function getDashboardStats()
    {
        $user = Auth::user();
        
        $stats = [
            'total' => Surat::where('nik_pemohon', $user->nik)->count(),
            'pending' => Surat::where('nik_pemohon', $user->nik)->where('status', 'Pending')->count(),
            'diproses' => Surat::where('nik_pemohon', $user->nik)->where('status', 'Diproses')->count(),
            'selesai' => Surat::where('nik_pemohon', $user->nik)->where('status', 'Selesai')->count(),
            'ditolak' => Surat::where('nik_pemohon', $user->nik)->where('status', 'Ditolak')->count(),
        ];
        
        return $stats;
    }
}