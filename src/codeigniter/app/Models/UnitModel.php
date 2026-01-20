<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitModel extends Model
{
    protected $table            = 'mUnit'; // Sesuai nama tabel di database
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;   // Karena ID varchar
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'nama_unit'];
}