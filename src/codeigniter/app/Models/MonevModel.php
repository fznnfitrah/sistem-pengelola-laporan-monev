<?php

namespace App\Models;

use CodeIgniter\Model;

class MonevModel extends Model
{
    protected $table            = 'mMonev'; // Sesuai nama di database
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_monev', 'status', 'keterangan'];
}