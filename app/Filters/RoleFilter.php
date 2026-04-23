<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // 1. Cek apakah user sudah login
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = $session->get('role');

        // 2. Periksa hak akses berdasarkan argumen yang dikirim dari Routes
        // Contoh: ['filter' => 'role:admin'] maka $arguments adalah ['admin']
        if (!empty($arguments)) {
            if (!in_array($userRole, $arguments)) {
                // Jika role user tidak ada dalam daftar yang diizinkan (misal user mau akses rute admin)
                return redirect()->to('/dashboard')->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk fitur ini.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak diperlukan untuk urusan filter role
    }
}