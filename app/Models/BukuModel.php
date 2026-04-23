<?php

namespace App\Models;
use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id_buku';

    protected $allowedFields = [
        'judul',
        'penulis',
        'penerbit',
        'tahun',
        'stok',
        'cover'
    ];
}

