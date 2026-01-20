<?php

namespace App\Models;

use CodeIgniter\Model;

class KinerjaModel extends Model
{
    protected $table            = 'mKinerja'; // Sesuai nama tabel di database
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_kinerja', 'jenis', 'satuan']; // Kolom sesuai gambar
}