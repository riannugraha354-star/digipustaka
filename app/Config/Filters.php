<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
// Pastikan imports di bawah ini ada jika Anda ingin menggunakan nama pendeknya saja
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use CodeIgniter\Filters\Cors;

class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        // Gunakan Full Namespace untuk menghindari error "Class not found"
        'forcehttps'    => \CodeIgniter\Filters\ForceHTTPS::class,
        'pagecache'     => \CodeIgniter\Filters\PageCache::class,
        'performance'   => \CodeIgniter\Filters\PerformanceMetrics::class,
        'auth'          => \App\Filters\AuthFilter::class,
        'role'          => \App\Filters\RoleFilter::class,
    ];

    public array $required = [
        'before' => [
            'forcehttps',
            'pagecache',
        ],
        'after' => [
            'pagecache',
            'performance',
            'toolbar',
        ],
    ];

    public array $globals = [
        'before' => [
            // Melindungi semua halaman kecuali yang ada di dalam array 'except'
            'auth' => [
                'except' => [
                    '/',
                    'login',
                    'proses-login',
                    'logout',
                    'restore',
                    'restore/auth',
                    'restore/form',
                    'restore/process',
                    'users/create',
                    'users/create/*', // Tambahkan asteris untuk jaga-jaga
                    'users/store'
                ]
            ]
        ],
        'after' => [
            // 'toolbar',
        ],
    ];
}
