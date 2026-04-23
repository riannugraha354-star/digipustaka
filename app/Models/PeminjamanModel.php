<?php

namespace App\Models;
use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_pinjam';

    protected $allowedFields = [
        'id_user',
        'id_buku',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status'
    ];
}