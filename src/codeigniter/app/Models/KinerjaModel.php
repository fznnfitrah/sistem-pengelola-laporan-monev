<?php

namespace App\Models;

use CodeIgniter\Model;

class KinerjaModel extends Model
{
    protected $table            = 'mKinerja';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    // Tambahkan field standar_nilai dan status sesuai gambar DB
    protected $allowedFields    = ['nama_kinerja', 'jenis', 'satuan', 'standar_nilai', 'status'];

    public function getKinerjaByJenis($jenis)
    {
        // Hanya ambil indikator yang statusnya Aktif (1)
        return $this->where('jenis', $jenis)
                    ->where('status', 1)
                    ->findAll();
    } 
}