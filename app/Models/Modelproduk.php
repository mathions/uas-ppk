<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelproduk extends Model
{
    protected $table = 'produk';
    protected $allowedFields = ['produk_nama', 'produk_harga', 'produk_gambar'];
}
