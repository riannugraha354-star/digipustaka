<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- Konfigurasi Middleware / Filter Keamanan ---
// Menentukan siapa saja yang boleh mengakses halaman tertentu berdasarkan status login dan role
$authFilter = ['filter' => 'auth']; // Harus Login
$admin      = ['filter' => 'role:admin']; // Khusus Admin
$user       = ['filter' => 'role:user']; // Khusus User

// --- Modul Autentikasi ---
// Jalur untuk masuk dan keluar dari sistem DigiPustaka
$routes->get('/login', 'Auth::login'); // Tampilan Form Login
$routes->post('/proses-login', 'Auth::prosesLogin'); // Proses Verifikasi Login
$routes->get('/logout', 'Auth::logout'); // Menghancurkan Session / Keluar

// --- Halaman Utama (Dashboard) ---
// Mengarahkan ke tampilan dashboard yang dinamis (Admin/User)
$routes->get('/', 'Home::index', $authFilter);
$routes->get('/dashboard', 'Home::index', $authFilter);

// --- Pengelolaan Data Buku (Katalog) ---
// CRUD data buku berdasarkan struktur tabel 'buku'
$routes->get('buku', 'Buku::index'); // List Buku
$routes->get('buku/detail/(:num)', 'Buku::detail/$1'); // Detail Buku
$routes->get('buku/create', 'Buku::create'); // Form Tambah Buku
$routes->post('buku/store', 'Buku::store'); // Simpan Buku Baru
$routes->get('buku/edit/(:num)', 'Buku::edit/$1'); // Form Edit Buku
$routes->post('buku/update/(:num)', 'Buku::update/$1'); // Update Data Buku
$routes->get('buku/delete/(:num)', 'Buku::delete/$1'); // Hapus Buku

// --- Sirkulasi Peminjaman ---
// Mengelola alur peminjaman sesuai Activity Diagram
$routes->get('peminjaman', 'Peminjaman::index'); // Riwayat Pinjam
$routes->get('peminjaman/create', 'Peminjaman::create'); // Form Peminjaman
$routes->post('peminjaman/store', 'Peminjaman::store'); // Proses Simpan Pinjam
$routes->get('peminjaman/print', 'Peminjaman::print'); // Cetak Laporan
$routes->get('pinjam/(:num)', 'Peminjaman::pinjam/$1'); // Shortcut Pinjam

// --- Alur Konfirmasi & Pengembalian ---
// Proses verifikasi oleh Admin sebelum status berubah
$routes->get('peminjaman/ajukan_kembali/(:num)', 'Peminjaman::ajukan_kembali/$1'); // User Kembalikan Buku
$routes->get('peminjaman/konfirmasi_pinjam/(:num)', 'Peminjaman::konfirmasi_pinjam/$1'); // Admin Setujui Pinjam
$routes->get('peminjaman/konfirmasi_kembali/(:num)', 'Peminjaman::konfirmasi_kembali/$1'); // Admin Setujui Kembali
$routes->get('peminjaman/delete/(:num)', 'Peminjaman::delete/$1'); // Hapus Data Transaksi

// --- Alias / Legacy Routes ---
// Link tambahan untuk memastikan fungsi lama tetap berjalan
$routes->get('peminjaman/setujui/(:num)', 'Peminjaman::konfirmasi_pinjam/$1');
$routes->get('peminjaman/kembali/(:num)', 'Peminjaman::konfirmasi_kembali/$1');

// --- Manajemen Pengguna (Users) ---
// CRUD akun admin dan user sesuai tabel 'users'
$routes->get('users', 'Users::index'); // Daftar Pengguna
$routes->get('users/create', 'Users::create'); // Tambah User
$routes->post('users/store', 'Users::store'); // Simpan User
$routes->get('users/edit/(:num)', 'Users::edit/$1'); // Edit Profil / User
$routes->post('users/update/(:num)', 'Users::update/$1'); // Update User
$routes->get('users/delete/(:num)', 'Users::delete/$1'); // Hapus User
$routes->get('users/wa/(:num)', 'Users::wa/$1'); // Integrasi WhatsApp Notifikasi

// --- Konfigurasi Sistem ---
$routes->get('peminjaman/denda', 'Peminjaman::denda'); // Cek Perhitungan Denda
$routes->get('setting', 'Setting::index'); // Pengaturan Aplikasi

// --- Keamanan Data (Maintenance) ---
// Fitur untuk menjaga database DigiPustaka tetap aman
$routes->get('/backup', 'Backup::index'); // Download Backup SQL
$routes->get('/restore', 'Restore::index'); // List Restore Point
$routes->post('/restore/auth', 'Restore::auth'); // Keamanan Restore
$routes->get('/restore/form', 'Restore::form'); // Upload File SQL
$routes->post('/restore/process', 'Restore::process'); // Eksekusi Restore

// --- Modul Keuangan (Denda User) ---
// Sisi User untuk melihat tagihan dan bayar via DANA/QRIS
$routes->get('/denda', 'Denda::index'); // Halaman Tagihan User
$routes->post('/denda/bayar/(:num)', 'Denda::bayar/$1'); // Proses Upload Bukti Bayar

// --- Modul Keuangan (Denda Admin) ---
// Sisi Admin untuk memverifikasi uang masuk
$routes->get('/admin/denda', 'Denda::admin'); // Daftar Antrian Verifikasi
$routes->get('/admin/denda/verifikasi/(:num)', 'Denda::verifikasi/$1'); // Setujui Pembayaran (Lunas)
$routes->get('/admin/denda/tolak/(:num)', 'Denda::tolak/$1'); // Tolak Pembayaran
$routes->get('denda/delete/(:num)', 'Denda::delete/$1'); // Hapus Riwayat Denda