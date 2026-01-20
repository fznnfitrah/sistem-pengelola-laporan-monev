<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanMonevModel extends Model
{
    protected $table            = 'laporan_monev';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'fk_prodi', 
        'fk_unit', 
        'fk_setting_periode', 
        'fk_monev', 
        'keterangan', 
        'link_bukti', 
        'create_at' // Sesuai gambar (bukan created_at)
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'create_at'; // Sesuai kolom DB Anda
    protected $updatedField  = ''; // Tidak ada updated_at di gambar

    // Fungsi untuk mengambil history laporan per Prodi beserta nama periode & jenis monevnya
    public function getLaporanByProdi($prodiId)
    {
        return $this->select('laporan_monev.*, mMonev.nama_monev, setting_periode.tahun_akademik, setting_periode.semester')
                    ->join('mMonev', 'mMonev.id = laporan_monev.fk_monev')
                    ->join('setting_periode', 'setting_periode.id = laporan_monev.fk_setting_periode')
                    ->where('laporan_monev.fk_prodi', $prodiId)
                    ->orderBy('laporan_monev.create_at', 'DESC')
                    ->findAll();
    }
}