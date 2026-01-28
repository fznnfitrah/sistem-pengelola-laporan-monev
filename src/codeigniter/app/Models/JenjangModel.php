<?php

namespace App\Models;

use CodeIgniter\Model;

class JenjangModel extends Model
{
    protected $table            = 'mJenjang';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['jenjang', 'keterangan']; // Sesuai kolom di gambar
}