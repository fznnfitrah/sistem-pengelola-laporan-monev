<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // Setup Column
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

    // Setup Timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'create_at';

    protected $updatedField  = '';

    protected $deletedField  = 'delete_at';


    public function getAllUsersWithRelations()
    {
        // Fungsi ini menggabungkan tabel user dengan tabel roles
        return $this->select('user.*, roles.nama_roles')
            ->join('roles', 'roles.id = user.fk_roles') // Hubungkan fk_roles dengan id roles
            ->findAll();
    }
}
