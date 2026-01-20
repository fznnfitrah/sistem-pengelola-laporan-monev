<?php

namespace App\Models;

use CodeIgniter\Model;

class PeriodeModel extends Model
{
    protected $table            = 'setting_periode'; // Sesuai nama tabel di database
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['create_by_fk_user', 'semester', 'tahun_akademik', 'status_aktif'];

    public function getActivePeriode()
    {
        return $this->where('status_aktif', 1)->first();
    }
}