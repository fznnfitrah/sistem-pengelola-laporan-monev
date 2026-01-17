<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'user'; // Nama tabel di PHPMyAdmin
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Daftarkan semua kolom agar bisa dibaca/ditulis oleh Controller
    protected $allowedFields    = [
        'username', 
        'email', 
        'password', 
        'fk_roles', 
        'fk_fakultas', 
        'fk_prodi', 
        'fk_unit', 
        'status'
    ];

    // Opsional: Gunakan timestamps jika tabelmu punya create_at/delete_at
    protected $useTimestamps = true;
    protected $createdField  = 'create_at';
    protected $deletedField  = 'delete_at';
}