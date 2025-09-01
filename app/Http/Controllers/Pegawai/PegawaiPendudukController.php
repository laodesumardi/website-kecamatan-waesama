<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PegawaiPendudukController extends Controller
{
    public function index(Request $request)
    {
        $query = Penduduk::query();
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('no_kk', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status_penduduk', $request->status);
        }
        
        // Filter by gender
        if ($request->has('gender') && $request->gender) {
            $query->where('jenis_kelamin', $request->gender);
        }
        
        // Filter by RT
        if ($request->has('rt') && $request->rt) {
            $query->where('rt', $request->rt);
        }
        
        // Filter by RW
        if ($request->has('rw') && $request->rw) {
            $query->where('rw', $request->rw);
        }
        
        $penduduk = $query->orderBy('nama_lengkap', 'asc')->paginate(15);
        
        // Get filter options
        $rtOptions = Penduduk::select('rt')->distinct()->orderBy('rt')->pluck('rt');
        $rwOptions = Penduduk::select('rw')->distinct()->orderBy('rw')->pluck('rw');
        
        return view('pegawai.penduduk.index', compact('penduduk', 'rtOptions', 'rwOptions'));
    }
    
    public function show(Penduduk $penduduk)
    {
        return view('pegawai.penduduk.show', compact('penduduk'));
    }
    
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query) {
            return response()->json([]);
        }
        
        $penduduk = Penduduk::where(function($q) use ($query) {
            $q->where('nik', 'like', "%{$query}%")
              ->orWhere('nama_lengkap', 'like', "%{$query}%")
              ->orWhere('no_kk', 'like', "%{$query}%");
        })
        ->select('id', 'nik', 'nama_lengkap', 'alamat', 'rt', 'rw')
        ->limit(10)
        ->get();
        
        return response()->json($penduduk);
    }
    
    public function stats()
    {
        $stats = [
            'total' => Penduduk::count(),
            'male' => Penduduk::where('jenis_kelamin', 'L')->count(),
            'female' => Penduduk::where('jenis_kelamin', 'P')->count(),
            'by_status' => Penduduk::select('status_penduduk', DB::raw('count(*) as total'))
                ->groupBy('status_penduduk')
                ->get(),
            'by_rt' => Penduduk::select('rt', DB::raw('count(*) as total'))
                ->groupBy('rt')
                ->orderBy('rt')
                ->get(),
            'by_rw' => Penduduk::select('rw', DB::raw('count(*) as total'))
                ->groupBy('rw')
                ->orderBy('rw')
                ->get(),
        ];
        
        return response()->json($stats);
    }
}