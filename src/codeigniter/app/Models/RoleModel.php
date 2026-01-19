<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    // Nama tabel sesuai database Anda
    protected $table            = 'roles';
    protected $primaryKey       = 'id';
    
    // Agar data dikembalikan dalam bentuk array (opsional, bisa juga 'object')
    protected $returnType       = 'array'; 
    protected $useAutoIncrement = true;

    // PENTING: Masukkan nama kolom persis seperti di phpMyAdmin
    protected $allowedFields    = ['nama_roles', 'deskripsi'];

    // PENTING: Set ke false karena di tabel Anda tidak ada kolom created_at & updated_at
    // Jika ini true (default), CI4 akan error saat mencoba update waktu.
    protected $useTimestamps    = false; 
}