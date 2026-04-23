<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- Variabel Filter (Optional jika ingin digunakan di grup) ---
$authFilter = ['filter' => 'auth'];
$admin      = ['filter' => 'role:admin'];
$user       = ['filter' => 'role:user'];

// --- Auth & Login ---
$routes->get('/login', 'Auth::login');
$routes->post('/proses-login', 'Auth::prosesLogin');
$routes->get('/logout', 'Auth::logout');

// --- Dashboard / Home ---
$routes->get('/', 'Home::index');
$routes->get('/dashboard', 'Home::index');

// --- Modul Buku ---
$routes->get('buku', 'Buku::index');
$routes->get('buku/detail/(:num)', 'Buku::detail/$1');
$routes->get('buku/create', 'Buku::create');
$routes->post('buku/store', 'Buku::store');
$routes->get('buku/edit/(:num)', 'Buku::edit/$1');
$routes->post('buku/update/(:num)', 'Buku::update/$1');
$routes->get('buku/delete/(:num)', 'Buku::delete/$1');

// --- Modul Peminjaman ---
$routes->get('peminjaman', 'Peminjaman::index');
$routes->get('peminjaman/create', 'Peminjaman::create');
$routes->post('peminjaman/store', 'Peminjaman::store');
$routes->get('peminjaman/print', 'Peminjaman::print');
$routes->get('pinjam/(:num)', 'Peminjaman::pinjam/$1'); 

// Aksi Peminjaman (Konfirmasi & Pengajuan)
$routes->get('peminjaman/ajukan_kembali/(:num)', 'Peminjaman::ajukan_kembali/$1');
$routes->get('peminjaman/konfirmasi_pinjam/(:num)', 'Peminjaman::konfirmasi_pinjam/$1');
$routes->get('peminjaman/konfirmasi_kembali/(:num)', 'Peminjaman::konfirmasi_kembali/$1');
$routes->get('peminjaman/delete/(:num)', 'Peminjaman::delete/$1');

// Alias Peminjaman (Jika masih dibutuhkan oleh link lama)
$routes->get('peminjaman/setujui/(:num)', 'Peminjaman::konfirmasi_pinjam/$1');
$routes->get('peminjaman/kembali/(:num)', 'Peminjaman::konfirmasi_kembali/$1');

// --- Modul Users ---
$routes->get('users', 'Users::index');
$routes->get('users/create', 'Users::create');
$routes->post('users/store', 'Users::store');
$routes->get('users/edit/(:num)', 'Users::edit/$1');
$routes->post('users/update/(:num)', 'Users::update/$1');
$routes->get('users/delete/(:num)', 'Users::delete/$1');
$routes->get('users/wa/(:num)', 'Users::wa/$1');

// --- Modul Denda & Settings ---
// Cari baris denda, lalu ubah menjadi:
// Cari baris denda di Routes.php dan ubah jadi ini:
$routes->get('peminjaman/denda', 'Peminjaman::denda');
$routes->get('setting', 'Setting::index');

// --- Backup & Restore Database ---
$routes->get('/backup', 'Backup::index');
$routes->get('/restore', 'Restore::index');
$routes->post('/restore/auth', 'Restore::auth');
$routes->get('/restore/form', 'Restore::form');
$routes->post('/restore/process', 'Restore::process');

