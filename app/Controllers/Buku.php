<?php

namespace App\Controllers;

use App\Models\BukuModel;

class Buku extends BaseController
{
    // 1. INDEX DENGAN SEARCH
    public function index()
    {
        $model = new BukuModel();
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $buku = $model->like('judul', $keyword)
                          ->orLike('penulis', $keyword)
                          ->findAll();
        } else {
            $buku = $model->findAll();
        }

        $data = [
            'buku'    => $buku,
            'keyword' => $keyword
        ];

        return view('buku/index', $data);
    }

    // 2. CREATE
    public function create()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/buku')->with('error', 'Hanya Admin yang bisa menambah buku!');
        }
        return view('buku/create');
    }

   public function store()
{
    if (session()->get('role') != 'admin') return redirect()->to('/buku');

    $model = new BukuModel();
    
    // Ambil file cover
    $fileCover = $this->request->getFile('cover');

    // Cek apakah file benar-benar diupload
    if ($fileCover && $fileCover->isValid() && !$fileCover->hasMoved()) {
        $namaCover = $fileCover->getRandomName();
        $fileCover->move('img', $namaCover); // Ini pindah ke public/img
    } else {
        $namaCover = 'default.jpg';
    }

    $model->save([
        'judul'    => $this->request->getPost('judul'),
        'penulis'  => $this->request->getPost('penulis'),
        'penerbit' => $this->request->getPost('penerbit'),
        'tahun'    => $this->request->getPost('tahun'),
        'stok'     => $this->request->getPost('stok'),
        'cover'    => $namaCover
    ]);

    return redirect()->to('/buku')->with('success', 'Buku berhasil ditambah!');
}
    // 3. EDIT & UPDATE
    public function edit($id)
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/buku')->with('error', 'Akses ditolak!');
        }

        $model = new BukuModel();
        $data['buku'] = $model->find($id);

        return view('buku/edit', $data);
    }

    public function update($id)
    {
        if (session()->get('role') != 'admin') return redirect()->to('/buku');

        $model = new BukuModel();
        $bukuLama = $model->find($id);

        // --- LOGIKA UPDATE COVER ---
        $fileCover = $this->request->getFile('cover');

        // Cek apakah user upload gambar baru
        if ($fileCover->getError() == 4) {
            $namaCover = $bukuLama['cover']; // Pakai nama lama
        } else {
            $namaCover = $fileCover->getRandomName();
            $fileCover->move('img', $namaCover);

            // Hapus file lama jika: bukan default, file-nya ada, DAN namanya gak kosong
if ($bukuLama['cover'] != 'default.jpg' && !empty($bukuLama['cover']) && file_exists('img/' . $bukuLama['cover'])) {
    unlink('img/' . $bukuLama['cover']);
}
        }
        // ---------------------------

        $model->update($id, [
            'judul'    => $this->request->getPost('judul'),
            'penulis'  => $this->request->getPost('penulis'),
            'penerbit' => $this->request->getPost('penerbit'),
            'tahun'    => $this->request->getPost('tahun'),
            'stok'     => $this->request->getPost('stok'),
            'cover'    => $namaCover
        ]);

        return redirect()->to('/buku')->with('success', 'Data buku berhasil diupdate!');
    }

    public function delete($id)
{
    if (session()->get('role') != 'admin') return redirect()->to('/buku');

    $model = new BukuModel();
    $buku = $model->find($id);

    // Tambahkan !empty($buku['cover'])
    if (!empty($buku['cover']) && $buku['cover'] != 'default.jpg' && file_exists('img/' . $buku['cover'])) {
        unlink('img/' . $buku['cover']);
    }

    $model->delete($id);
    return redirect()->to('/buku')->with('success', 'Data buku berhasil dihapus!');
}

    public function detail($id)
    {
        $model = new BukuModel();
        $data['buku'] = $model->find($id);

        if (empty($data['buku'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Buku tidak ditemukan');
        }

        return view('buku/detail', $data);
    }
}