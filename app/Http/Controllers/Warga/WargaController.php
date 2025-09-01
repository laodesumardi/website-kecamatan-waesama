<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\Antrian;
use App\Models\Pengaduan;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WargaController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'my_surat' => Surat::where('nik_pemohon', $user->nik)->count(),
            'my_antrian' => Antrian::where('nik_pengunjung', $user->nik)->count(),
            'my_pengaduan' => Pengaduan::where('email_pengadu', $user->email)->count(),
        ];

        $recentNews = Berita::where('status', 'Published')
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        return view('warga.dashboard', compact('stats', 'recentNews'));
    }
}
