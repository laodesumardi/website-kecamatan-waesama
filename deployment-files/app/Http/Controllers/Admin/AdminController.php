<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Penduduk;
use App\Models\Surat;
use App\Models\Antrian;
use App\Models\Berita;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_penduduk' => Penduduk::count(),
            'total_surat' => Surat::count(),
            'pending_surat' => Surat::where('status', 'Pending')->count(),
            'total_antrian' => Antrian::count(),
            'active_antrian' => Antrian::whereIn('status', ['Menunggu', 'Dipanggil'])->count(),
            'total_berita' => Berita::count(),
            'published_berita' => Berita::where('status', 'Published')->count(),
            'total_pengaduan' => Pengaduan::count(),
            'pending_pengaduan' => Pengaduan::where('status', 'Diterima')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
