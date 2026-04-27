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
        $id_user = session()->get('id_user');
        $role = session()->get('role');

        // REVISI: Cek denda sebelum masuk halaman tambah
        if ($role != 'admin') {
            $punyaDenda = $this->dendaModel
                ->join('peminjaman', 'peminjaman.id_pinjam = denda.id_pinjam')
                ->where('peminjaman.id_user', $id_user)
                ->whereIn('denda.status', ['belum_bayar', 'menunggu_verifikasi'])
                ->first();

            if ($punyaDenda) {
                return redirect()->to('/peminjaman')->with('error', 'buku tidak bisa di pinjam karna denda belum di bayar');
            }
        }

        return view('peminjaman/create', [
            'users' => $this->usersModel->findAll(),
            'buku' => $this->bukuModel->where('stok >', 0)->findAll()
        ]);
    }

    public function store()
    {
        $id_user = (session('role') == 'admin') ? $this->request->getPost('id_user') : session('id_user');
        $id_buku = $this->request->getPost('id_buku');

        // REVISI: Validasi denda saat menekan tombol simpan
        if (session('role') != 'admin') {
            $cekDenda = $this->dendaModel
                ->join('peminjaman', 'peminjaman.id_pinjam = denda.id_pinjam')
                ->where('peminjaman.id_user', $id_user)
                ->whereIn('denda.status', ['belum_bayar', 'menunggu_verifikasi'])
                ->first();

            if ($cekDenda) {
                return redirect()->to('/peminjaman')->with('error', 'buku tidak bisa di pinjam karna denda belum di bayar');
            }
        }

        // Lanjut proses simpan peminjaman
        $this->peminjamanModel->save([
            'id_user'         => $id_user,
            'id_buku'         => $id_buku,
            'tanggal_pinjam'  => date('Y-m-d'),
            'tanggal_kembali' => date('Y-m-d', strtotime('+7 days')),
            'status'          => 'pending'
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Permintaan pinjam berhasil dikirim!');
    }

    public function pinjam($id_buku)
    {
        $id_user = session()->get('id_user');

        // REVISI: Validasi denda untuk tombol pinjam cepat di katalog
        $cekDenda = $this->dendaModel
            ->join('peminjaman', 'peminjaman.id_pinjam = denda.id_pinjam')
            ->where('peminjaman.id_user', $id_user)
            ->whereIn('denda.status', ['belum_bayar', 'menunggu_verifikasi'])
            ->first();

        if ($cekDenda) {
            return redirect()->to('/peminjaman')->with('error', 'buku tidak bisa di pinjam karna denda belum di bayar');
        }

        $dataBuku = $this->bukuModel->find($id_buku);
        if (!$dataBuku || $dataBuku['stok'] <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok buku sedang habis!');
        }

        $this->peminjamanModel->save([
            'id_user'         => $id_user,
            'id_buku'         => $id_buku,
            'tanggal_pinjam'  => date('Y-m-d'),
            'tanggal_kembali' => date('Y-m-d', strtotime('+7 days')),
            'status'          => 'pending'
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Permintaan pinjam terkirim!');
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