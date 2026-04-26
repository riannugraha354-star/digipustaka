<?php

namespace App\Controllers;

// Memanggil Model agar controller bisa berinteraksi dengan database
use App\Models\DendaModel;
use App\Models\PeminjamanModel;

class Denda extends BaseController
{
    // Properti untuk menyimpan instance model
    protected $dendaModel;
    protected $peminjamanModel;

    // Method Construct: Otomatis dijalankan saat controller dipanggil
    public function __construct()
    {
        // Inisialisasi model agar siap digunakan di semua method
        $this->dendaModel = new DendaModel();
        $this->peminjamanModel = new PeminjamanModel();
    }

    // ==========================================
    // USER: LIHAT DAFTAR TAGIHAN DENDA SAYA
    // ==========================================
    public function index()
    {
        // Ambil ID User dari session login
        $userId = session('id_user');

        // Query Join: Menghubungkan tabel denda dengan tabel peminjaman
        // Untuk memfilter agar user hanya melihat dendanya sendiri
        $data['denda'] = $this->dendaModel
            ->select('denda.*, peminjaman.id_user')
            ->join('peminjaman', 'peminjaman.id_pinjam = denda.id_pinjam')
            ->where('peminjaman.id_user', $userId)
            ->findAll();

        // Mengirim data denda ke view user
        return view('denda/index', $data);
    }

    // ==========================================
    // USER: PROSES UPLOAD BUKTI PEMBAYARAN (DANA/QRIS)
    // ==========================================
    public function bayar($id)
    {
        // Menangkap file bukti bayar dari form
        $file = $this->request->getFile('bukti');
        
        // Validasi: Cek apakah file ada dan ekstensinya sesuai (Keamanan file)
        if (!$file->isValid() || !in_array($file->getExtension(), ['jpg', 'png', 'jpeg'])) {
            return redirect()->back()->with('error', 'Format file tidak valid. Harap upload file jpg, png, atau jpeg.');
        }

        if ($file && $file->isValid()) {
            // Generate nama file unik agar tidak bentrok di folder uploads
            $namaFile = $file->getRandomName();
            // Pindahkan file ke folder public/uploads/bukti
            $file->move('uploads/bukti', $namaFile);

            // Update status denda menjadi 'menunggu_verifikasi' agar muncul di dashboard admin
            $this->dendaModel->update($id, [
                'metode_bayar' => $this->request->getPost('metode_bayar'),
                'bukti' => $namaFile,
                'status' => 'menunggu_verifikasi'
            ]);

            return redirect()->back()->with('success', 'Bukti berhasil diupload.');
        }

        return redirect()->back()->with('error', 'Upload gagal.');
    }

    // ==========================================
    // ADMIN: LIST SEMUA ANTRIAN DENDA MASUK
    // ==========================================
    public function admin()
    {
        // Keamanan: Hanya Role Admin yang boleh masuk ke halaman ini
        if (session('role') != 'admin') return redirect()->to('/');

        // Mengambil semua data denda dari semua user untuk dipantau admin
        $data['denda'] = $this->dendaModel
            ->select('denda.*, peminjaman.id_user')
            ->join('peminjaman', 'peminjaman.id_pinjam = denda.id_pinjam')
            ->findAll();

        return view('denda/admin', $data);
    }

    // ==========================================
    // ADMIN: VERIFIKASI PEMBAYARAN (SETUJUI)
    // ==========================================
    public function verifikasi($id)
    {
        // Mengubah status menjadi lunas (Sesuai Activity Diagram)
        $this->dendaModel->update($id, [
            'status' => 'lunas'
        ]);

        return redirect()->back()->with('success', 'Pembayaran dikonfirmasi.');
    }

    // ==========================================
    // ADMIN: TOLAK PEMBAYARAN (BUKTI TIDAK VALID)
    // ==========================================
    public function tolak($id)
    {
        // Mengembalikan status menjadi ditolak agar user bisa upload ulang
        $this->dendaModel->update($id, [
            'status' => 'ditolak'
        ]);

        return redirect()->back()->with('error', 'Pembayaran ditolak.');
    }

    // ==========================================
    // ADMIN: HAPUS RIWAYAT DENDA
    // ==========================================
    public function delete($id)
    {
        // Proteksi route dari akses ilegal
        if (session()->get('role') != 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }

        // Eksekusi penghapusan data secara permanen di database
        $this->dendaModel->delete($id);

        return redirect()->back()->with('success', 'Data denda berhasil dihapus.');
    }
}