<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdiModel extends Model
{
    protected $table = 'mProdi'; // Sesuai database kamu
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false; // Karena varchar(20)
    protected $allowedFields = [
        'id',
        'fk_fakultas',
        'nama_prodi',
        'fk_jenjang',
        'no_sk_pendirian',
        'tgl_sk_pendirian',
    ];

    
}
