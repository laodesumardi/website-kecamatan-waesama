<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Production Optimizations
    |--------------------------------------------------------------------------
    |
    | Konfigurasi khusus untuk environment production
    |
    */

    'optimizations' => [
        'config_cache' => true,
        'route_cache' => true,
        'view_cache' => true,
        'autoload_optimize' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Error Handling
    |--------------------------------------------------------------------------
    |
    | Konfigurasi penanganan error untuk production
    |
    */

    'error_handling' => [
        'log_all_errors' => true,
        'hide_error_details' => true,
        'custom_error_pages' => true,
        'error_notification' => [
            'enabled' => false,
            'email' => 'admin@waesama.go.id',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Settings
    |--------------------------------------------------------------------------
    |
    | Pengaturan keamanan untuk production
    |
    */

    'security' => [
        'force_https' => true,
        'secure_cookies' => true,
        'csrf_protection' => true,
        'rate_limiting' => [
            'enabled' => true,
            'max_attempts' => 60,
            'decay_minutes' => 1,
        ],
        'headers' => [
            'x_frame_options' => 'DENY',
            'x_content_type_options' => 'nosniff',
            'x_xss_protection' => '1; mode=block',
            'referrer_policy' => 'strict-origin-when-cross-origin',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Performance Settings
    |--------------------------------------------------------------------------
    |
    | Pengaturan performa untuk production
    |
    */

    'performance' => [
        'compression' => [
            'enabled' => true,
            'level' => 6,
        ],
        'caching' => [
            'browser_cache_ttl' => 2592000, // 30 days
            'static_files_ttl' => 31536000, // 1 year
        ],
        'database' => [
            'query_cache' => true,
            'connection_pooling' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Monitoring
    |--------------------------------------------------------------------------
    |
    | Pengaturan monitoring untuk production
    |
    */

    'monitoring' => [
        'health_check' => [
            'enabled' => true,
            'endpoint' => '/health',
        ],
        'metrics' => [
            'enabled' => false,
            'endpoint' => '/metrics',
        ],
        'uptime' => [
            'enabled' => false,
            'url' => null,
        ],
    ],
];