<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'user'; // Nama tabel di database
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'fk_roles', 'fk_fakultas', 'fk_prodi', 'status'];
}