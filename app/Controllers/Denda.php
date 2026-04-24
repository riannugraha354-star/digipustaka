<?php

namespace App\Controllers;

use App\Models\DendaModel;
use App\Models\PeminjamanModel;

class Denda extends BaseController
{
    protected $dendaModel;
    protected $peminjamanModel;

    public function __construct()
    {
        $this->dendaModel = new DendaModel();
        $this->peminjamanModel = new PeminjamanModel();
    }

    // =========================
    // USER: LIHAT DENDA
    // =========================
    public function index()
    {
        $userId = session('id_user');

        $data['denda'] = $this->dendaModel
            ->select('denda.*, peminjaman.id_user')
            ->join('peminjaman', 'peminjaman.id_pinjam = denda.id_pinjam')
            ->where('peminjaman.id_user', $userId)
            ->findAll();

        return view('denda/index', $data);
    }

    // =========================
    // USER: UPLOAD BUKTI
    // =========================
    public function bayar($id)
    {
        $file = $this->request->getFile('bukti');
        if (!$file->isValid() || !in_array($file->getExtension(), ['jpg', 'png', 'jpeg'])) {
            return redirect()->back()->with('error', 'Format file tidak valid. Harap upload file jpg, png, atau jpeg.');
        }

        if ($file && $file->isValid()) {
            $namaFile = $file->getRandomName();
            $file->move('uploads/bukti', $namaFile);

            $this->dendaModel->update($id, [
                'metode_bayar' => $this->request->getPost('metode_bayar'),
                'bukti' => $namaFile,
                'status' => 'menunggu_verifikasi'
            ]);

            return redirect()->back()->with('success', 'Bukti berhasil diupload.');
        }

        return redirect()->back()->with('error', 'Upload gagal.');
    }

    // =========================
    // ADMIN: LIST SEMUA DENDA
    // =========================
    public function admin()
    {
        if (session('role') != 'admin') return redirect()->to('/');

        $data['denda'] = $this->dendaModel
            ->select('denda.*, peminjaman.id_user')
            ->join('peminjaman', 'peminjaman.id_pinjam = denda.id_pinjam')
            ->findAll();

        return view('denda/admin', $data);
    }

    // =========================
    // ADMIN: VERIFIKASI
    // =========================
    public function verifikasi($id)
    {
        $this->dendaModel->update($id, [
            'status' => 'lunas'
        ]);

        return redirect()->back()->with('success', 'Pembayaran dikonfirmasi.');
    }

    // =========================
    // ADMIN: TOLAK
    // =========================
    public function tolak($id)
    {
        $this->dendaModel->update($id, [
            'status' => 'ditolak'
        ]);

        return redirect()->back()->with('error', 'Pembayaran ditolak.');
    }

    public function delete($id)
{
    // Pastikan hanya admin yang bisa menghapus
    if (session()->get('role') != 'admin') {
        return redirect()->to('/')->with('error', 'Akses ditolak!');
    }

    // Hapus data denda berdasarkan ID
    // Jika denda dihapus, otomatis data tersebut hilang dari list user
    $this->dendaModel->delete($id);

    return redirect()->back()->with('success', 'Data denda berhasil dihapus.');
}
}
