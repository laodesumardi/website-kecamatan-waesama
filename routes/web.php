<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\PendudukController;
use App\Http\Controllers\Admin\SuratController;
use App\Http\Controllers\Admin\AntrianController;
use App\Http\Controllers\Admin\PengaduanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Pegawai\PegawaiController;
use App\Http\Controllers\Pegawai\SuratController as PegawaiSuratController;
use App\Http\Controllers\Warga\WargaController;
use App\Http\Controllers\Warga\SuratController as WargaSuratController;
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
    Route::resource('penduduk', PendudukController::class);
    Route::resource('surat', SuratController::class);
    
    // Additional surat routes
    Route::post('surat/{surat}/process', [SuratController::class, 'process'])->name('surat.process');
    Route::post('surat/{surat}/complete', [SuratController::class, 'complete'])->name('surat.complete');
    Route::get('surat/{surat}/download', [SuratController::class, 'download'])->name('surat.download');
    Route::get('surat/{surat}/export-pdf', [SuratController::class, 'exportPdf'])->name('surat.export-pdf');
    
    Route::resource('antrian', AntrianController::class);
    
    // Additional antrian routes
    Route::get('antrian-dashboard', [AntrianController::class, 'dashboard'])->name('antrian.dashboard');
    Route::post('antrian/{antrian}/call', [AntrianController::class, 'call'])->name('antrian.call');
    Route::post('antrian/{antrian}/serve', [AntrianController::class, 'serve'])->name('antrian.serve');
    Route::post('antrian/{antrian}/complete', [AntrianController::class, 'complete'])->name('antrian.complete');
    Route::post('antrian/{antrian}/cancel', [AntrianController::class, 'cancel'])->name('antrian.cancel');
    
    Route::resource('pengaduan', PengaduanController::class);
    
    // Additional pengaduan routes
    Route::post('pengaduan/{pengaduan}/process', [PengaduanController::class, 'process'])->name('pengaduan.process');
    Route::post('pengaduan/{pengaduan}/followup', [PengaduanController::class, 'followup'])->name('pengaduan.followup');
    Route::post('pengaduan/{pengaduan}/complete', [PengaduanController::class, 'complete'])->name('pengaduan.complete');
    Route::post('pengaduan/{pengaduan}/reject', [PengaduanController::class, 'reject'])->name('pengaduan.reject');
    Route::get('pengaduan/{pengaduan}/download', [PengaduanController::class, 'download'])->name('pengaduan.download');
    Route::get('pengaduan/{pengaduan}/export-pdf', [PengaduanController::class, 'exportPdf'])->name('pengaduan.export-pdf');
    
    Route::resource('user', UserController::class);
    
    // Additional user routes
    Route::patch('user/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('user.toggle-status');
    Route::patch('user/{user}/reset-password', [UserController::class, 'resetPassword'])->name('user.reset-password');
    
    // Laporan routes
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
});

// Content Routes (accessible by all authenticated users)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/content', function () {
        return view('content.index');
    })->name('content.index');
});

// Pegawai Routes
Route::middleware(['auth', 'verified', 'role:Pegawai'])->prefix('pegawai')->name('pegawai.')->group(function () {
    Route::get('/dashboard', [PegawaiController::class, 'dashboard'])->name('dashboard');
    
    // Surat routes
    Route::get('/surat', [PegawaiSuratController::class, 'index'])->name('surat.index');
    Route::get('/surat/{surat}', [PegawaiSuratController::class, 'show'])->name('surat.show');
    Route::get('/surat/{surat}/download', [PegawaiSuratController::class, 'download'])->name('surat.download');
    Route::get('/surat/{surat}/export-pdf', [PegawaiSuratController::class, 'exportPdf'])->name('surat.export-pdf');
});

// Warga Routes
Route::middleware(['auth', 'verified', 'role:Warga'])->prefix('warga')->name('warga.')->group(function () {
    Route::get('/dashboard', [WargaController::class, 'dashboard'])->name('dashboard');
    
    // Surat routes
    Route::get('/surat', [WargaSuratController::class, 'index'])->name('surat.index');
    Route::get('/surat/{surat}', [WargaSuratController::class, 'show'])->name('surat.show');
    Route::get('/surat/{surat}/download', [WargaSuratController::class, 'download'])->name('surat.download');
    Route::get('/surat/{surat}/export-pdf', [WargaSuratController::class, 'exportPdf'])->name('surat.export-pdf');
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
