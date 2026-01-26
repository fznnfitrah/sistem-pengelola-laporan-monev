<?php

namespace App\Models;

use CodeIgniter\Model;

class LembagaModel extends Model
{
    protected $table            = 'mLembaga_akreditasi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_lembaga', 'jenis_lembaga', 'biaya', 'url', 'alamat'];
}