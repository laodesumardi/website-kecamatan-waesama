<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Surat::with('processor')
                     ->where('nik_pemohon', $user->nik);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('keperluan', 'like', "%{$search}%");
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
        
        return view('warga.surat.index', compact('surat'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Surat $surat)
    {
        $user = Auth::user();
        
        // Pastikan warga hanya bisa melihat surat milik sendiri
        if ($surat->nik_pemohon !== $user->nik) {
            abort(403, 'Anda tidak memiliki akses ke surat ini.');
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
        
        // Pastikan warga hanya bisa download surat milik sendiri
        if ($surat->nik_pemohon !== $user->nik) {
            abort(403, 'Anda tidak memiliki akses ke surat ini.');
        }
        
        if (!$surat->file_surat || !Storage::disk('public')->exists($surat->file_surat)) {
            return redirect()->back()->with('error', 'File surat tidak ditemukan.');
        }
        
        return Storage::disk('public')->download($surat->file_surat, $surat->nomor_surat . '.pdf');
    }

    /**
     * Export surat to PDF
     */
    public function exportPdf(Surat $surat)
    {
        $user = Auth::user();
        
        // Pastikan warga hanya bisa export surat milik sendiri
        if ($surat->nik_pemohon !== $user->nik) {
            abort(403, 'Anda tidak memiliki akses ke surat ini.');
        }
        
        // Load the surat with processor relationship
        $surat->load('processor');
        
        // Generate PDF
        $pdf = Pdf::loadView('pdf.surat', compact('surat'));
        $pdf->setPaper('A4', 'portrait');
        
        // Generate filename
        $filename = 'Surat_' . str_replace('/', '_', $surat->nomor_surat) . '.pdf';
        
        // Return PDF download
        return $pdf->download($filename);
    }
}