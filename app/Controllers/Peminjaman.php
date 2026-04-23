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
            ->join('denda', 'denda.id_pinjam = peminjaman.id_pinjam', 'left'); // 🔥 penting

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
        return view('peminjaman/create', [
            'users' => $this->usersModel->findAll(),
            'buku' => $this->bukuModel->where('stok >', 0)->findAll()
        ]);
    }

    public function store()
    {
        $id_buku = $this->request->getPost('id_buku');
        $dataBuku = $this->bukuModel->find($id_buku);

        if (!$dataBuku || $dataBuku['stok'] <= 0) {
            return redirect()->back()->with('error', 'Stok buku habis!');
        }

        $status = (session('role') == 'admin') ? 'dipinjam' : 'pending';

        $this->peminjamanModel->save([
            'id_user'         => (session('role') == 'admin') ? $this->request->getPost('id_user') : session('id_user'),
            'id_buku'         => $id_buku,
            'tanggal_pinjam'  => $this->request->getPost('tanggal_pinjam') ?: date('Y-m-d'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali') ?: date('Y-m-d', strtotime('+7 days')),
            'status'          => $status
        ]);

        if ($status == 'dipinjam') {
            $this->bukuModel->update($id_buku, ['stok' => $dataBuku['stok'] - 1]);
        }

        return redirect()->to('/peminjaman')->with('success', 'Data berhasil diproses!');
    }

    public function konfirmasi_pinjam($id)
    {
        if (session('role') != 'admin') return redirect()->to('/');
        $data = $this->peminjamanModel->find($id);
        $buku = $this->bukuModel->find($data['id_buku']);

        if ($buku['stok'] > 0) {
            $this->peminjamanModel->update($id, ['status' => 'dipinjam']);
            $this->bukuModel->update($data['id_buku'], ['stok' => $buku['stok'] - 1]);
            return redirect()->back()->with('success', 'Peminjaman disetujui!');
        }
        return redirect()->back()->with('error', 'Stok habis!');
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

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $tanggalSekarang = date('Y-m-d');
        $tanggalKembali = $data['tanggal_kembali'];

        // cek apakah terlambat
        if ($tanggalSekarang > $tanggalKembali) {

            // hitung selisih hari keterlambatan
            $terlambat = (strtotime($tanggalSekarang) - strtotime($tanggalKembali)) / (60 * 60 * 24);

            // contoh: denda 1000 per hari
            $dendaPerHari = 1000;
            $totalDenda = $terlambat * $dendaPerHari;

            // update status jadi terdenda
            $this->peminjamanModel->update($id, [
                'status' => 'terdenda'
            ]);

            // insert ke tabel denda
            $this->dendaModel->insert([
                'id_pinjam' => $id,
                'denda'         => $totalDenda,
                'metode_bayar'  => null,
                'status'        => 'belum_bayar',
                'bukti'         => null
            ]);

            $message = 'Buku terlambat dikembalikan. Denda ditambahkan.';
        } else {

            // jika tidak terlambat
            $this->peminjamanModel->update($id, [
                'status' => 'kembali'
            ]);

            $message = 'Buku diterima kembali.';
        }

        // kembalikan stok buku
        $buku = $this->bukuModel->find($data['id_buku']);
        $this->bukuModel->update($data['id_buku'], [
            'stok' => $buku['stok'] + 1
        ]);

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

    public function pinjam($id_buku)
    {
        $dataBuku = $this->bukuModel->find($id_buku);

        if (!$dataBuku || $dataBuku['stok'] <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok buku sedang habis!');
        }

        $this->peminjamanModel->save([
            'id_user'         => session()->get('id_user'),
            'id_buku'         => $id_buku,
            'tanggal_pinjam'  => date('Y-m-d'),
            'tanggal_kembali' => date('Y-m-d', strtotime('+7 days')),
            'status'          => 'pending'
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Permintaan pinjam terkirim!');
    }

    // --- TAMBAHAN FUNGSI DENDA (TIDAK MERUBAH KODE DI ATAS) ---
    public function denda()
    {
        if (session('role') != 'admin') return redirect()->to('/');

        $tgl_sekarang = date('Y-m-d');

        $data['peminjaman'] = $this->peminjamanModel
            ->select('peminjaman.*, users.nama, buku.judul')
            ->join('users', 'users.id_user = peminjaman.id_user')
            ->join('buku', 'buku.id_buku = peminjaman.id_buku')
            ->where('peminjaman.denda >', 0)
            ->orWhere("(peminjaman.status = 'dipinjam' AND peminjaman.tanggal_kembali < '$tgl_sekarang')")
            ->findAll();

        $data['tgl_sekarang'] = $tgl_sekarang;

        return view('peminjaman/denda', $data);
    }
}
