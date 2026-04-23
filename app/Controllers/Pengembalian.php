<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use App\Models\BukuModel;

class Pengembalian extends BaseController
{
    public function index()
    {
        $model = new PeminjamanModel();

        // Ambil data dengan urutan terbaru
        $data['pengembalian'] = $model
            ->select('peminjaman.*, users.nama, buku.judul')
            ->join('users', 'users.id_user = peminjaman.id_user')
            ->join('buku', 'buku.id_buku = peminjaman.id_buku')
            ->orderBy('id_pinjam', 'DESC')
            ->findAll();

        return view('pengembalian/index', $data);
    }

    public function setuju($id)
    {
        $peminjamanModel = new PeminjamanModel();
        $bukuModel = new BukuModel();

        $dataPinjam = $peminjamanModel->find($id);

        if (!$dataPinjam) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Update status menjadi 'dikembalikan' (Agar badge Hijau muncul)
        $peminjamanModel->update($id, ['status' => 'dikembalikan']);

        // Tambah stok buku (+1)
        $buku = $bukuModel->find($dataPinjam['id_buku']);
        if ($buku) {
            $bukuModel->update($dataPinjam['id_buku'], [
                'stok' => $buku['stok'] + 1
            ]);
        }

        return redirect()->to(base_url('pengembalian'))->with('success', 'Konfirmasi Berhasil! Buku telah diterima dan stok bertambah.');
    }

    public function tolak($id)
    {
        $peminjamanModel = new PeminjamanModel();
        
        if ($peminjamanModel->find($id)) {
            $peminjamanModel->update($id, ['status' => 'ditolak']);
            return redirect()->to(base_url('pengembalian'))->with('success', 'Pengembalian buku ditolak.');
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }

    
}