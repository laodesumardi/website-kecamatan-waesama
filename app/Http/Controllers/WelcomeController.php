<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Display the welcome page with news and public content
     */
    public function index()
    {
        // Get latest published news
        $latestNews = Berita::where('status', 'Published')
            ->orderBy('published_at', 'desc')
            ->take(6)
            ->get();
            
        // Get featured news
        $featuredNews = Berita::where('status', 'Published')
            ->where('is_featured', true)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
            
        // Get recent announcements (news with specific categories if needed)
        $announcements = Berita::where('status', 'Published')
            ->orderBy('published_at', 'desc')
            ->take(4)
            ->get();
            
        return view('welcome', compact('latestNews', 'featuredNews', 'announcements'));
    }
}