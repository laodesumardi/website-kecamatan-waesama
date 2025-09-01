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
use App\Http\Controllers\Pegawai\PegawaiAntrianController;
use App\Http\Controllers\Pegawai\PegawaiPengaduanController;
use App\Http\Controllers\Pegawai\PegawaiPendudukController;
use App\Http\Controllers\Pegawai\PegawaiLaporanController;
use App\Http\Controllers\Warga\WargaController;
use App\Http\Controllers\Warga\WargaSuratController;
use App\Http\Controllers\Warga\WargaAntrianController;
use App\Http\Controllers\Warga\WargaPengaduanController;
use App\Http\Controllers\Warga\BookmarkController as WargaBookmarkController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PublicPengaduanController;
use App\Http\Controllers\PublicAntrianController;
use App\Http\Controllers\PublicKontakController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\NotificationController;
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
    
    // Berita routes with explicit parameter names
    Route::get('berita', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('berita/create', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('berita', [BeritaController::class, 'store'])->name('berita.store');
    Route::get('berita/{berita}', [BeritaController::class, 'show'])->name('berita.show');
    Route::get('berita/{berita}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('berita/{berita}', [BeritaController::class, 'update'])->name('berita.update');
    Route::patch('berita/{berita}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('berita/{berita}', [BeritaController::class, 'destroy'])->name('berita.destroy');
    
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
    
    // Settings routes
    Route::get('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
    Route::post('settings/update-realtime', [\App\Http\Controllers\Admin\SettingsController::class, 'updateRealtime'])->name('settings.update-realtime');
    Route::post('settings/clear-cache', [\App\Http\Controllers\Admin\SettingsController::class, 'clearCache'])->name('settings.clear-cache');
    Route::get('settings/backup', [\App\Http\Controllers\Admin\SettingsController::class, 'backup'])->name('settings.backup');
    Route::get('settings/system-info', [\App\Http\Controllers\Admin\SettingsController::class, 'systemInfo'])->name('settings.system-info');
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
    
    // Antrian routes
    Route::get('/antrian', [PegawaiAntrianController::class, 'index'])->name('antrian.index');
    Route::get('/antrian/{antrian}', [PegawaiAntrianController::class, 'show'])->name('antrian.show');
    Route::post('/antrian/{antrian}/call', [PegawaiAntrianController::class, 'call'])->name('antrian.call');
    Route::post('/antrian/{antrian}/serve', [PegawaiAntrianController::class, 'serve'])->name('antrian.serve');
    Route::post('/antrian/{antrian}/complete', [PegawaiAntrianController::class, 'complete'])->name('antrian.complete');
    Route::post('/antrian/{antrian}/cancel', [PegawaiAntrianController::class, 'cancel'])->name('antrian.cancel');
    Route::get('/antrian/stats/my', [PegawaiAntrianController::class, 'myStats'])->name('antrian.my-stats');
    
    // Pengaduan routes
    Route::get('/pengaduan', [PegawaiPengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/{pengaduan}', [PegawaiPengaduanController::class, 'show'])->name('pengaduan.show');
    Route::get('/pengaduan/{pengaduan}/download', [PegawaiPengaduanController::class, 'download'])->name('pengaduan.download');
    Route::post('/pengaduan/{pengaduan}/process', [PegawaiPengaduanController::class, 'process'])->name('pengaduan.process');
    Route::post('/pengaduan/{pengaduan}/follow-up', [PegawaiPengaduanController::class, 'followUp'])->name('pengaduan.follow-up');
    Route::post('/pengaduan/{pengaduan}/complete', [PegawaiPengaduanController::class, 'complete'])->name('pengaduan.complete');
    Route::post('/pengaduan/{pengaduan}/reject', [PegawaiPengaduanController::class, 'reject'])->name('pengaduan.reject');
    Route::post('/pengaduan/{pengaduan}/take', [PegawaiPengaduanController::class, 'take'])->name('pengaduan.take');
    Route::get('/pengaduan/stats/my', [PegawaiPengaduanController::class, 'myStats'])->name('pengaduan.my-stats');
    
    // Data Penduduk routes
    Route::get('/penduduk', [PegawaiPendudukController::class, 'index'])->name('penduduk.index');
    Route::get('/penduduk/{penduduk}', [PegawaiPendudukController::class, 'show'])->name('penduduk.show');
    Route::get('/penduduk/search/api', [PegawaiPendudukController::class, 'search'])->name('penduduk.search');
    Route::get('/penduduk/stats/api', [PegawaiPendudukController::class, 'stats'])->name('penduduk.stats');
    
    // Laporan routes
    Route::get('/laporan', [PegawaiLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [PegawaiLaporanController::class, 'export'])->name('laporan.export');
});

// Warga Routes
Route::middleware(['auth', 'verified', 'role:Warga'])->prefix('warga')->name('warga.')->group(function () {
    Route::get('/dashboard', [WargaController::class, 'dashboard'])->name('dashboard');
    
    // Surat routes
    Route::get('/surat', [WargaSuratController::class, 'index'])->name('surat.index');
    Route::get('/surat/list', [WargaSuratController::class, 'list'])->name('surat.list');
    Route::get('/surat/create', [WargaSuratController::class, 'create'])->name('surat.create');
    Route::post('/surat', [WargaSuratController::class, 'store'])->name('surat.store');
    Route::get('/surat/{surat}', [WargaSuratController::class, 'show'])->name('surat.show');
    Route::get('/surat/{surat}/download', [WargaSuratController::class, 'download'])->name('surat.download');
    Route::get('/surat/{surat}/export-pdf', [WargaSuratController::class, 'exportPdf'])->name('surat.export-pdf');
    
    // Berita route
    Route::get('/berita', [WargaController::class, 'berita'])->name('berita.index');
    
    // Bookmark routes
    Route::get('/bookmarks', [WargaBookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmark/{berita}', [WargaBookmarkController::class, 'toggle'])->name('bookmark.toggle');
    
    // Antrian routes
    Route::get('/antrian', [WargaAntrianController::class, 'index'])->name('antrian.index');
    Route::get('/antrian/create', [WargaAntrianController::class, 'create'])->name('antrian.create');
    Route::post('/antrian', [WargaAntrianController::class, 'store'])->name('antrian.store');
    Route::put('/antrian/{id}/cancel', [WargaAntrianController::class, 'cancel'])->name('antrian.cancel');
    
    // Pengaduan routes
    Route::get('/pengaduan', [WargaPengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/create', [WargaPengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('/pengaduan', [WargaPengaduanController::class, 'store'])->name('pengaduan.store');
    
    // Profil routes
    Route::get('/profil', [WargaController::class, 'profil'])->name('profil');
    Route::put('/profil', [WargaController::class, 'updateProfil'])->name('profil.update');
    Route::put('/profil/password', [WargaController::class, 'updatePassword'])->name('profil.password');
});

// Public Routes
Route::get('/berita', [PublicController::class, 'berita'])->name('public.berita');
Route::get('/berita/{slug}', [PublicController::class, 'beritaDetail'])->name('public.berita.detail');
Route::get('/profil', [PublicController::class, 'profil'])->name('public.profil');
Route::get('/kontak', [PublicController::class, 'kontak'])->name('public.kontak');
Route::get('/layanan', [PublicController::class, 'layanan'])->name('public.layanan');

// Public pengaduan route
Route::post('/pengaduan/submit', [PublicPengaduanController::class, 'store'])->name('public.pengaduan.store');

// Public Antrian Routes
Route::post('/antrian/submit', [PublicAntrianController::class, 'store'])->name('public.antrian.store');

// Public Kontak Routes
Route::post('/kontak/submit', [PublicKontakController::class, 'store'])->name('public.kontak.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Notification routes
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::get('/notifications/page', function() { return view('notifications.index'); })->name('notifications.page');
Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::patch('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
Route::post('/notifications/send', [NotificationController::class, 'sendNotification'])->name('notifications.send');
    Route::post('/notifications/send-to-role', [NotificationController::class, 'sendToRole'])->name('notifications.send-to-role');
    
    // API routes for notifications
    Route::get('/api/users', function() {
        return response()->json(\App\Models\User::select('id', 'name', 'email')->get());
    });
});

require __DIR__.'/auth.php';
