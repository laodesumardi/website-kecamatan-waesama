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
use App\Http\Controllers\Admin\SettingsController;
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

// Welcome Page
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Dashboard redirect based on role
Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    if (!$user->role || !$user->role->name) {
        Auth::logout();
        return redirect()->route('login')->with('error', 'Role tidak valid. Silakan hubungi administrator.');
    }

    switch ($user->role->name) {
        case 'Admin':
            return redirect()->route('admin.dashboard');
        case 'Pegawai':
            return redirect()->route('pegawai.dashboard');
        case 'Warga':
            return redirect()->route('warga.dashboard');
        default:
            Auth::logout();
            return redirect()->route('login')->with('error', 'Role tidak dikenal.');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'verified', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Berita Management
    Route::prefix('berita')->name('berita.')->group(function () {
        Route::get('/', [BeritaController::class, 'index'])->name('index');
        Route::get('/create', [BeritaController::class, 'create'])->name('create');
        Route::post('/', [BeritaController::class, 'store'])->name('store');
        Route::get('/{berita}', [BeritaController::class, 'show'])->name('show')->where('berita', '[0-9]+');
        Route::get('/{berita}/edit', [BeritaController::class, 'edit'])->name('edit')->where('berita', '[0-9]+');
        Route::put('/{berita}', [BeritaController::class, 'update'])->name('update')->where('berita', '[0-9]+');
        Route::delete('/{berita}', [BeritaController::class, 'destroy'])->name('destroy')->where('berita', '[0-9]+');
    });

    // Penduduk Management
    Route::prefix('penduduk')->name('penduduk.')->group(function () {
        Route::get('/', [PendudukController::class, 'index'])->name('index');
        Route::get('/create', [PendudukController::class, 'create'])->name('create');
        Route::post('/', [PendudukController::class, 'store'])->name('store');
        Route::get('/{penduduk}', [PendudukController::class, 'show'])->name('show')->where('penduduk', '[0-9]+');
        Route::get('/{penduduk}/edit', [PendudukController::class, 'edit'])->name('edit')->where('penduduk', '[0-9]+');
        Route::put('/{penduduk}', [PendudukController::class, 'update'])->name('update')->where('penduduk', '[0-9]+');
        Route::delete('/{penduduk}', [PendudukController::class, 'destroy'])->name('destroy')->where('penduduk', '[0-9]+');
        Route::post('/import', [PendudukController::class, 'import'])->name('import');
    });

    // Surat Management
    Route::prefix('surat')->name('surat.')->group(function () {
        Route::get('/', [SuratController::class, 'index'])->name('index');
        Route::get('/create', [SuratController::class, 'create'])->name('create');
        Route::post('/', [SuratController::class, 'store'])->name('store');
        Route::get('/{surat}', [SuratController::class, 'show'])->name('show')->where('surat', '[0-9]+');
        Route::get('/{surat}/edit', [SuratController::class, 'edit'])->name('edit')->where('surat', '[0-9]+');
        Route::put('/{surat}', [SuratController::class, 'update'])->name('update')->where('surat', '[0-9]+');
        Route::delete('/{surat}', [SuratController::class, 'destroy'])->name('destroy')->where('surat', '[0-9]+');
        Route::post('/{surat}/process', [SuratController::class, 'process'])->name('process')->where('surat', '[0-9]+');
        Route::post('/{surat}/complete', [SuratController::class, 'complete'])->name('complete')->where('surat', '[0-9]+');
        Route::get('/{surat}/download', [SuratController::class, 'download'])->name('download')->where('surat', '[0-9]+');
        Route::get('/{surat}/export-pdf', [SuratController::class, 'exportPdf'])->name('export-pdf')->where('surat', '[0-9]+');
    });

    // Antrian Management
    Route::prefix('antrian')->name('antrian.')->group(function () {
        Route::get('/', [AntrianController::class, 'index'])->name('index');
        Route::get('/create', [AntrianController::class, 'create'])->name('create');
        Route::post('/', [AntrianController::class, 'store'])->name('store');
        Route::get('/dashboard', [AntrianController::class, 'dashboard'])->name('dashboard');
        Route::get('/{antrian}', [AntrianController::class, 'show'])->name('show')->where('antrian', '[0-9]+');
        Route::get('/{antrian}/edit', [AntrianController::class, 'edit'])->name('edit')->where('antrian', '[0-9]+');
        Route::put('/{antrian}', [AntrianController::class, 'update'])->name('update')->where('antrian', '[0-9]+');
        Route::delete('/{antrian}', [AntrianController::class, 'destroy'])->name('destroy')->where('antrian', '[0-9]+');
        Route::post('/{antrian}/call', [AntrianController::class, 'call'])->name('call')->where('antrian', '[0-9]+');
        Route::post('/{antrian}/serve', [AntrianController::class, 'serve'])->name('serve')->where('antrian', '[0-9]+');
        Route::post('/{antrian}/complete', [AntrianController::class, 'complete'])->name('complete')->where('antrian', '[0-9]+');
        Route::post('/{antrian}/cancel', [AntrianController::class, 'cancel'])->name('cancel')->where('antrian', '[0-9]+');
    });

    // Pengaduan Management
    Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
        Route::get('/', [PengaduanController::class, 'index'])->name('index');
        Route::get('/create', [PengaduanController::class, 'create'])->name('create');
        Route::post('/', [PengaduanController::class, 'store'])->name('store');
        Route::get('/{pengaduan}', [PengaduanController::class, 'show'])->name('show')->where('pengaduan', '[0-9]+');
        Route::get('/{pengaduan}/edit', [PengaduanController::class, 'edit'])->name('edit')->where('pengaduan', '[0-9]+');
        Route::put('/{pengaduan}', [PengaduanController::class, 'update'])->name('update')->where('pengaduan', '[0-9]+');
        Route::delete('/{pengaduan}', [PengaduanController::class, 'destroy'])->name('destroy')->where('pengaduan', '[0-9]+');
        Route::post('/{pengaduan}/process', [PengaduanController::class, 'process'])->name('process')->where('pengaduan', '[0-9]+');
        Route::post('/{pengaduan}/followup', [PengaduanController::class, 'followup'])->name('followup')->where('pengaduan', '[0-9]+');
        Route::post('/{pengaduan}/complete', [PengaduanController::class, 'complete'])->name('complete')->where('pengaduan', '[0-9]+');
        Route::post('/{pengaduan}/reject', [PengaduanController::class, 'reject'])->name('reject')->where('pengaduan', '[0-9]+');
        Route::get('/{pengaduan}/download', [PengaduanController::class, 'download'])->name('download')->where('pengaduan', '[0-9]+');
        Route::get('/{pengaduan}/export-pdf', [PengaduanController::class, 'exportPdf'])->name('export-pdf')->where('pengaduan', '[0-9]+');
    });

    // User Management
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show')->where('user', '[0-9]+');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit')->where('user', '[0-9]+');
        Route::put('/{user}', [UserController::class, 'update'])->name('update')->where('user', '[0-9]+');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy')->where('user', '[0-9]+');
        Route::patch('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status')->where('user', '[0-9]+');
        Route::patch('/{user}/reset-password', [UserController::class, 'resetPassword'])->name('reset-password')->where('user', '[0-9]+');
    });

    // Laporan Management
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/export', [LaporanController::class, 'export'])->name('export');
    });

    // Settings Management
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::put('/', [SettingsController::class, 'update'])->name('update');
        Route::post('/update-realtime', [SettingsController::class, 'updateRealtime'])->name('update-realtime');
        Route::post('/clear-cache', [SettingsController::class, 'clearCache'])->name('clear-cache');
        Route::get('/backup', [SettingsController::class, 'backup'])->name('backup');
        Route::get('/system-info', [SettingsController::class, 'systemInfo'])->name('system-info');
    });
});

// Pegawai Routes
Route::middleware(['auth', 'verified', 'role:Pegawai'])->prefix('pegawai')->name('pegawai.')->group(function () {
    Route::get('/dashboard', [PegawaiController::class, 'dashboard'])->name('dashboard');

    Route::prefix('surat')->name('surat.')->group(function () {
        Route::get('/', [PegawaiSuratController::class, 'index'])->name('index');
        Route::get('/{surat}', [PegawaiSuratController::class, 'show'])->name('show')->where('surat', '[0-9]+');
        Route::get('/{surat}/download', [PegawaiSuratController::class, 'download'])->name('download')->where('surat', '[0-9]+');
        Route::get('/{surat}/export-pdf', [PegawaiSuratController::class, 'exportPdf'])->name('export-pdf')->where('surat', '[0-9]+');
    });

    Route::prefix('antrian')->name('antrian.')->group(function () {
        Route::get('/', [PegawaiAntrianController::class, 'index'])->name('index');
        Route::get('/{antrian}', [PegawaiAntrianController::class, 'show'])->name('show')->where('antrian', '[0-9]+');
        Route::post('/{antrian}/call', [PegawaiAntrianController::class, 'call'])->name('call')->where('antrian', '[0-9]+');
        Route::post('/{antrian}/serve', [PegawaiAntrianController::class, 'serve'])->name('serve')->where('antrian', '[0-9]+');
        Route::post('/{antrian}/complete', [PegawaiAntrianController::class, 'complete'])->name('complete')->where('antrian', '[0-9]+');
        Route::post('/{antrian}/cancel', [PegawaiAntrianController::class, 'cancel'])->name('cancel')->where('antrian', '[0-9]+');
        Route::get('/stats/my', [PegawaiAntrianController::class, 'myStats'])->name('my-stats');
    });

    Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
        Route::get('/', [PegawaiPengaduanController::class, 'index'])->name('index');
        Route::get('/{pengaduan}', [PegawaiPengaduanController::class, 'show'])->name('show')->where('pengaduan', '[0-9]+');
        Route::get('/{pengaduan}/download', [PegawaiPengaduanController::class, 'download'])->name('download')->where('pengaduan', '[0-9]+');
        Route::post('/{pengaduan}/process', [PegawaiPengaduanController::class, 'process'])->name('process')->where('pengaduan', '[0-9]+');
        Route::post('/{pengaduan}/follow-up', [PegawaiPengaduanController::class, 'followUp'])->name('follow-up')->where('pengaduan', '[0-9]+');
        Route::post('/{pengaduan}/complete', [PegawaiPengaduanController::class, 'complete'])->name('complete')->where('pengaduan', '[0-9]+');
        Route::post('/{pengaduan}/reject', [PegawaiPengaduanController::class, 'reject'])->name('reject')->where('pengaduan', '[0-9]+');
        Route::post('/{pengaduan}/take', [PegawaiPengaduanController::class, 'take'])->name('take')->where('pengaduan', '[0-9]+');
        Route::get('/stats/my', [PegawaiPengaduanController::class, 'myStats'])->name('my-stats');
    });

    Route::prefix('penduduk')->name('penduduk.')->group(function () {
        Route::get('/', [PegawaiPendudukController::class, 'index'])->name('index');
        Route::get('/{penduduk}', [PegawaiPendudukController::class, 'show'])->name('show')->where('penduduk', '[0-9]+');
        Route::get('/search/api', [PegawaiPendudukController::class, 'search'])->name('search');
        Route::get('/stats/api', [PegawaiPendudukController::class, 'stats'])->name('stats');
        Route::post('/import', [PegawaiPendudukController::class, 'import'])->name('import');
    });

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [PegawaiLaporanController::class, 'index'])->name('index');
        Route::get('/export', [PegawaiLaporanController::class, 'export'])->name('export');
    });
});

// Warga Routes
Route::middleware(['auth', 'verified', 'role:Warga'])->prefix('warga')->name('warga.')->group(function () {
    Route::get('/dashboard', [WargaController::class, 'dashboard'])->name('dashboard');

    Route::prefix('surat')->name('surat.')->group(function () {
        Route::get('/', [WargaSuratController::class, 'index'])->name('index');
        Route::get('/list', [WargaSuratController::class, 'list'])->name('list');
        Route::get('/create', [WargaSuratController::class, 'create'])->name('create');
        Route::post('/', [WargaSuratController::class, 'store'])->name('store');
        Route::get('/{surat}', [WargaSuratController::class, 'show'])->name('show')->where('surat', '[0-9]+');
        Route::get('/{surat}/download', [WargaSuratController::class, 'download'])->name('download')->where('surat', '[0-9]+');
        Route::get('/{surat}/export-pdf', [WargaSuratController::class, 'exportPdf'])->name('export-pdf')->where('surat', '[0-9]+');
    });

    Route::get('/berita', [WargaController::class, 'berita'])->name('berita.index');

    Route::prefix('bookmarks')->name('bookmarks.')->group(function () {
        Route::get('/', [WargaBookmarkController::class, 'index'])->name('index');
    });
    Route::post('/bookmark/{berita}', [WargaBookmarkController::class, 'toggle'])->name('bookmark.toggle')->where('berita', '[0-9]+');

    Route::prefix('antrian')->name('antrian.')->group(function () {
        Route::get('/', [WargaAntrianController::class, 'index'])->name('index');
        Route::get('/create', [WargaAntrianController::class, 'create'])->name('create');
        Route::post('/', [WargaAntrianController::class, 'store'])->name('store');
        Route::put('/{id}/cancel', [WargaAntrianController::class, 'cancel'])->name('cancel')->where('id', '[0-9]+');
    });

    Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
        Route::get('/', [WargaPengaduanController::class, 'index'])->name('index');
        Route::get('/create', [WargaPengaduanController::class, 'create'])->name('create');
        Route::post('/', [WargaPengaduanController::class, 'store'])->name('store');
    });

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
Route::post('/pengaduan/submit', [PublicPengaduanController::class, 'store'])->name('public.pengaduan.store');
Route::post('/antrian/submit', [PublicAntrianController::class, 'store'])->name('public.antrian.store');
Route::post('/kontak/submit', [PublicKontakController::class, 'store'])->name('public.kontak.store');

// CSRF token refresh route
Route::get('/csrf-token', function () {
    return response()->json(['token' => csrf_token()]);
})->name('csrf.token');

// Profile & Notification Routes
Route::middleware(['auth'])->group(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/page', function () {
            return view('notifications.index');
        })->name('page');
        Route::get('/unread-count', [NotificationController::class, 'unreadCount'])->name('unread-count');
        Route::patch('/{notification}/read', [NotificationController::class, 'markAsRead'])->name('read')->where('notification', '[0-9]+');
        Route::patch('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy')->where('notification', '[0-9]+');
        Route::post('/send', [NotificationController::class, 'sendNotification'])->name('send');
        Route::post('/send-to-role', [NotificationController::class, 'sendToRole'])->name('send-to-role');
    });

    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/users', function () {
            try {
                return response()->json(\App\Models\User::select('id', 'name', 'email')->get());
            } catch (\Exception $e) {
                return response()->json(['error' => 'Unable to fetch users'], 500);
            }
        })->name('users');
    });
});

require __DIR__ . '/auth.php';
