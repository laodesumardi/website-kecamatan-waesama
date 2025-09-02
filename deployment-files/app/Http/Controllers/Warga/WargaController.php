<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\Antrian;
use App\Models\Pengaduan;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

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

    public function berita(Request $request)
    {
        $query = Berita::where('status', 'Published');

        // Filter berdasarkan kategori jika ada
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Search berdasarkan judul atau konten
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('konten', 'like', '%' . $search . '%')
                  ->orWhere('excerpt', 'like', '%' . $search . '%');
            });
        }

        // Ambil berita utama (terbaru) - hanya jika tidak ada filter
        $featuredNews = null;
        if (!$request->filled('search') && !$request->filled('kategori')) {
            $featuredNews = Berita::where('status', 'Published')
                ->orderBy('published_at', 'desc')
                ->first();
        }

        // Ambil berita lainnya dengan pagination
        $berita = $query->orderBy('published_at', 'desc')
            ->when($featuredNews, function($q) use ($featuredNews) {
                return $q->where('id', '!=', $featuredNews->id);
            })
            ->paginate(9);

        // Handle AJAX request
        if ($request->ajax()) {
            $html = view('warga.partials.berita-grid', compact('berita'))->render();
            $pagination = $berita->hasPages() ? $berita->links()->render() : '';
            
            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => $pagination,
                'total' => $berita->total()
            ]);
        }

        return view('warga.berita', compact('berita', 'featuredNews'));
    }

    public function profil()
    {
        $user = Auth::user();
        return view('warga.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'nik' => ['required', 'string', 'size:16', 'unique:users,nik,' . $user->id],
            'no_hp' => ['nullable', 'string', 'max:15'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'phone' => $request->no_hp,
            'address' => $request->alamat,
        ]);

        return redirect()->route('warga.profil')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('warga.profil')->with('success', 'Password berhasil diubah.');
    }
}
