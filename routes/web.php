<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Pegawai\PegawaiController;
use App\Http\Controllers\Warga\WargaController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Dashboard redirect based on role
Route::get('/dashboard', function () {
    $user = Auth::user();
    
    if (!$user) {
        return redirect()->route('login');
    }
    
    // Check if user has a role assigned
    if (!$user->role) {
        return redirect()->route('login')->with('error', 'Role tidak ditemukan. Silakan hubungi administrator.');
    }
    
    switch ($user->role->name) {
        case 'Admin':
            return redirect()->route('admin.dashboard');
        case 'Pegawai':
            return redirect()->route('pegawai.dashboard');
        case 'Warga':
            return redirect()->route('warga.dashboard');
        default:
            return redirect()->route('login');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'verified', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('berita', BeritaController::class);
});

// Pegawai Routes
Route::middleware(['auth', 'verified', 'role:Pegawai'])->prefix('pegawai')->name('pegawai.')->group(function () {
    Route::get('/dashboard', [PegawaiController::class, 'dashboard'])->name('dashboard');
});

// Warga Routes
Route::middleware(['auth', 'verified', 'role:Warga'])->prefix('warga')->name('warga.')->group(function () {
    Route::get('/dashboard', [WargaController::class, 'dashboard'])->name('dashboard');
});

// Public Routes
Route::get('/berita', [PublicController::class, 'berita'])->name('public.berita');
Route::get('/berita/{slug}', [PublicController::class, 'beritaDetail'])->name('public.berita.detail');
Route::get('/profil', [PublicController::class, 'profil'])->name('public.profil');
Route::get('/kontak', [PublicController::class, 'kontak'])->name('public.kontak');
Route::get('/layanan', [PublicController::class, 'layanan'])->name('public.layanan');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
