<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display the news page
     */
    public function berita()
    {
        $berita = Berita::where('status', 'Published')
            ->orderBy('published_at', 'desc')
            ->paginate(9);
            
        $featuredNews = Berita::where('status', 'Published')
            ->where('is_featured', true)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
            
        return view('public.berita', compact('berita', 'featuredNews'));
    }
    
    /**
     * Display single news article
     */
    public function beritaDetail($slug)
    {
        $berita = Berita::where('slug', $slug)
            ->where('status', 'Published')
            ->firstOrFail();
            
        // Increment views
        $berita->increment('views');
        
        $relatedNews = Berita::where('status', 'Published')
            ->where('id', '!=', $berita->id)
            ->orderBy('published_at', 'desc')
            ->take(4)
            ->get();
            
        return view('public.berita-detail', compact('berita', 'relatedNews'));
    }
    
    /**
     * Display office profile page
     */
    public function profil()
    {
        return view('public.profil');
    }
    
    /**
     * Display contact page
     */
    public function kontak()
    {
        return view('public.kontak');
    }
    
    /**
     * Display services page
     */
    public function layanan()
    {
        return view('public.layanan');
    }
}
