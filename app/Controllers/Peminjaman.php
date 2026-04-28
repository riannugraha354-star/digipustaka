<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\BukuModel;
use App\Models\UsersModel;
use App\Models\DendaModel;

class Peminjaman extends BaseController
{
    protected $peminjamanModel;
    protected $bukuModel;
    protected $usersModel;
    protected $dendaModel;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
        $this->bukuModel = new BukuModel();
        $this->usersModel = new UsersModel();
        $this->dendaModel = new DendaModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $id_user = session()->get('id_user');

        $builder = $this->peminjamanModel
            ->select('
            peminjaman.*, 
            users.nama, 
            buku.judul,
            denda.denda as jumlah_denda
        ')
            ->join('users', 'users.id_user = peminjaman.id_user')
            ->join('buku', 'buku.id_buku = peminjaman.id_buku')
            ->join('denda', 'denda.id_pinjam = peminjaman.id_pinjam', 'left');

        if ($role != 'admin') {
            $builder->where('peminjaman.id_user', $id_user);
        }

        $data['peminjaman'] = $builder
            ->orderBy('peminjaman.id_pinjam', 'DESC')
            ->findAll();

        return view('peminjaman/index', $data);
    }

   public function create()
{
    // Ambil ID User yang sedang login dari session
$id_user_login = session()->get('id_user'); 
$role = session()->get('role');

if ($role != 'admin') {
    // Kita cek langsung ke tabel denda, tapi kita saring berdasarkan user_id di tabel peminjaman
    $cekDendaSaya = $this->dendaModel
        ->select('denda.*, peminjaman.id_user') // Ambil data denda dan id_user peminjam
        ->join('peminjaman', 'peminjaman.id_pinjam = denda.id_pinjam')
        ->where('peminjaman.id_user', $id_user_login) // PASTIIN INI: Cek ID saya saja!
        ->whereIn('denda.status', ['belum_bayar', 'menunggu_verifikasi'])
        ->first();

    // Jika sistem menemukan denda yang "id_user"-nya adalah SAYA, baru blokir
    if ($cekDendaSaya) {
        return redirect()->to('/denda')->with('error', 'Akses ditolak! Kamu punya denda yang belum lunas.');
    }
}

    // Jika aman (tidak ada denda), baru tampilkan halaman tambah pinjam
    return view('peminjaman/create', [
        'buku' => $this->bukuModel->findAll(),
        // ... data lainnya
    ]);
}
   public function store()
{
    $id_user_login = session()->get('id_user');
    $role = session()->get('role');

    if ($role != 'admin') {
        $cekDenda = $this->dendaModel
            ->join('peminjaman', 'peminjaman.id_pinjam = denda.id_pinjam')
            ->where('peminjaman.id_user', $id_user_login)
            ->whereIn('denda.status', ['belum_bayar', 'menunggu_verifikasi'])
            ->first();

        if ($cekDenda) {
            return redirect()->to('/denda')->with('error', 'Proses dibatalkan! Kamu masih punya denda aktif.');
        }
    }

    // ... lanjutkan proses simpan data ke database ...
}

 public function pinjam($id_buku)
{
    $id_user_login = session()->get('id_user');
    $role = session()->get('role');

    // --- STEP 1: SATPAM (Pengecekan Denda) ---
    // Jangan biarkan user lanjut ke bawah kalau dia punya denda
    if ($role != 'admin') {
        $cekDendaSaya = $this->dendaModel
            ->join('peminjaman', 'peminjaman.id_pinjam = denda.id_pinjam')
            ->where('peminjaman.id_user', $id_user_login)
            ->whereIn('denda.status', ['belum_bayar', 'menunggu_verifikasi'])
            ->first();

        if ($cekDendaSaya) {
            // Jika ada denda, lempar ke halaman denda & hentikan proses (return)
            return redirect()->to('/denda')->with('error', 'buku tidak bisa di pinjam karna denda belum di bayar');
        }
    }

    // --- STEP 2: PROSES (Jika Lolos Cek Denda) ---
    $tgl_pinjam = date('Y-m-d');
    $tgl_kembali_estimasi = date('Y-m-d', strtotime('+7 days'));

    $data = [
        'id_user'         => $id_user_login,
        'id_buku'         => $id_buku,
        'tanggal_pinjam'  => $tgl_pinjam,
        'tanggal_kembali' => $tgl_kembali_estimasi, // Fix agar tidak 1970
        'status'          => 'pending'
    ];

    $this->peminjamanModel->insert($data);

    // Kirim notif sukses hijau
    return redirect()->to('/peminjaman')->with('success', 'Permintaan pinjam terkirim!');
}
   public function konfirmasi_pinjam($id)
{
    // 1. Tentukan tanggal hari ini sebagai awal pinjam
    $tgl_pinjam = date('Y-m-d');
    
    // 2. Tambahkan durasi pinjam (misal 7 hari ke depan)
    $tgl_kembali = date('Y-m-d', strtotime('+7 days', strtotime($tgl_pinjam)));

    // 3. Update database dengan status 'dipinjam' dan tanggal kembali yang benar
    $this->peminjamanModel->update($id, [
        'status'          => 'dipinjam',
        'tanggal_pinjam'  => $tgl_pinjam,
        'tanggal_kembali' => $tgl_kembali // INI HARUS ADA BIAR GAK 1970
    ]);

    return redirect()->to('/peminjaman')->with('success', 'Peminjaman disetujui!');
}
    public function ajukan_kembali($id)
    {
        $this->peminjamanModel->update($id, ['status' => 'menunggu_kembali']);
        return redirect()->back()->with('success', 'Laporan kembali dikirim!');
    }

    public function konfirmasi_kembali($id)
    {
        if (session('role') != 'admin') return redirect()->to('/');

        $data = $this->peminjamanModel->find($id);
        if (!$data) return redirect()->back()->with('error', 'Data tidak ditemukan.');

        $tanggalSekarang = date('Y-m-d');
        $tanggalKembali = $data['tanggal_kembali'];

        if ($tanggalSekarang > $tanggalKembali) {
            $terlambat = (strtotime($tanggalSekarang) - strtotime($tanggalKembali)) / (60 * 60 * 24);
            $dendaPerHari = 1000;
            $totalDenda = $terlambat * $dendaPerHari;

            $this->peminjamanModel->update($id, ['status' => 'terdenda']);

            $this->dendaModel->insert([
                'id_pinjam'    => $id,
                'denda'        => $totalDenda,
                'metode_bayar' => null,
                'status'       => 'belum_bayar',
                'bukti'        => null
            ]);

            $message = 'Buku terlambat dikembalikan. Denda ditambahkan.';
        } else {
            $this->peminjamanModel->update($id, ['status' => 'kembali']);
            $message = 'Buku diterima kembali.';
        }

        $buku = $this->bukuModel->find($data['id_buku']);
        $this->bukuModel->update($data['id_buku'], ['stok' => $buku['stok'] + 1]);

        return redirect()->back()->with('success', $message);
    }

    public function delete($id)
    {
        if (session('role') != 'admin') return redirect()->to('/');
        $this->peminjamanModel->delete($id);
        return redirect()->to('/peminjaman')->with('success', 'Data dihapus.');
    }

    public function print()
    {
        $data['peminjaman'] = $this->peminjamanModel
            ->select('peminjaman.*, users.nama, buku.judul')
            ->join('users', 'users.id_user = peminjaman.id_user')
            ->join('buku', 'buku.id_buku = peminjaman.id_buku')
            ->orderBy('id_pinjam', 'DESC')->findAll();
        return view('peminjaman/print', $data);
    }

    public function denda()
    {
        if (session('role') != 'admin') return redirect()->to('/');

        $tgl_sekarang = date('Y-m-d');
        $data['peminjaman'] = $this->peminjamanModel
            ->select('peminjaman.*, users.nama, buku.judul')
            ->join('users', 'users.id_user = peminjaman.id_user')
            ->join('buku', 'buku.id_buku = peminjaman.id_buku')
            ->where('peminjaman.status', 'terdenda')
            ->findAll();

        $data['tgl_sekarang'] = $tgl_sekarang;
        return view('peminjaman/denda', $data);
    }
}