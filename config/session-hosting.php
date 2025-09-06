<?php

use Illuminate\Support\Str;

/**
 * Konfigurasi Session untuk Hosting Production
 * File ini berisi konfigurasi session yang dioptimasi untuk hosting shared/production
 * untuk mengatasi masalah error 419 Page Expired
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Default Session Driver
    |--------------------------------------------------------------------------
    |
    | Untuk hosting shared, gunakan 'file' driver karena lebih stabil
    | dan tidak memerlukan konfigurasi tambahan seperti Redis/Memcached
    |
    */

    'driver' => env('SESSION_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Session Lifetime
    |--------------------------------------------------------------------------
    |
    | Waktu session dalam menit. Untuk hosting, gunakan waktu yang cukup
    | untuk menghindari timeout terlalu cepat
    |
    */

    'lifetime' => env('SESSION_LIFETIME', 120),

    'expire_on_close' => false,

    /*
    |--------------------------------------------------------------------------
    | Session Encryption
    |--------------------------------------------------------------------------
    |
    | Untuk performa yang lebih baik di hosting shared, disable encryption
    | kecuali data session sangat sensitif
    |
    */

    'encrypt' => env('SESSION_ENCRYPT', false),

    /*
    |--------------------------------------------------------------------------
    | Session File Location
    |--------------------------------------------------------------------------
    |
    | Path untuk menyimpan session files. Pastikan folder ini writable
    |
    */

    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | Session Database Connection
    |--------------------------------------------------------------------------
    |
    | Jika menggunakan database driver, tentukan koneksi database
    |
    */

    'connection' => env('SESSION_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | Session Database Table
    |--------------------------------------------------------------------------
    |
    | Nama tabel untuk menyimpan session jika menggunakan database driver
    |
    */

    'table' => 'sessions',

    /*
    |--------------------------------------------------------------------------
    | Session Cache Store
    |--------------------------------------------------------------------------
    |
    | Cache store untuk session jika menggunakan cache driver
    |
    */

    'store' => env('SESSION_STORE'),

    /*
    |--------------------------------------------------------------------------
    | Session Sweeping Lottery
    |--------------------------------------------------------------------------
    |
    | Probabilitas untuk membersihkan session expired
    | [2, 100] berarti 2% chance setiap request
    |
    */

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Name
    |--------------------------------------------------------------------------
    |
    | Nama cookie session. Gunakan nama yang unik untuk aplikasi
    |
    */

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
    ),

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Path
    |--------------------------------------------------------------------------
    |
    | Path cookie session. Gunakan '/' untuk seluruh domain
    |
    */

    'path' => env('SESSION_PATH', '/'),

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Domain
    |--------------------------------------------------------------------------
    |
    | Domain cookie session. Untuk subdomain, gunakan '.domain.com'
    | Untuk hosting shared, biasanya null atau sesuai domain utama
    |
    */

    'domain' => env('SESSION_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | HTTPS Only Cookies
    |--------------------------------------------------------------------------
    |
    | Set true jika website menggunakan HTTPS
    | Untuk development (HTTP), set false
    |
    */

    'secure' => env('SESSION_SECURE_COOKIE', env('APP_ENV') === 'production'),

    /*
    |--------------------------------------------------------------------------
    | HTTP Access Only
    |--------------------------------------------------------------------------
    |
    | Set true untuk mencegah akses cookie via JavaScript (XSS protection)
    |
    */

    'http_only' => env('SESSION_HTTP_ONLY', true),

    /*
    |--------------------------------------------------------------------------
    | Same-Site Cookies
    |--------------------------------------------------------------------------
    |
    | Konfigurasi SameSite untuk cookie session
    | Options: 'lax', 'strict', 'none', null
    |
    */

    'same_site' => env('SESSION_SAME_SITE', 'lax'),

    /*
    |--------------------------------------------------------------------------
    | Partitioned Cookies
    |--------------------------------------------------------------------------
    |
    | Set true untuk menggunakan partitioned cookies (Chrome 118+)
    |
    */

    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),

];