<?php

namespace App\Models;

use CodeIgniter\Model;

class KinerjaProdiUnitModel extends Model
{
    protected $table = 'kinerja_prodi_unit'; // Tabel Transaksi
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'fk_kinerja', 'fk_setting_periode', 
        'fk_prodi', 'fk_unit', 'fk_user', 
        'value', 'keterangan', 'link_bukti', 'created_at'
    ];
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; 
}