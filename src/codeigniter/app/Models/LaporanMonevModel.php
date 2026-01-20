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
        'create_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'create_at';
    protected $updatedField  = ''; 

    // 1. Buat fungsi private untuk logika JOIN yang berulang
    private function _getBaseQuery()
    {
        return $this->select('laporan_monev.*, mMonev.nama_monev, setting_periode.tahun_akademik, setting_periode.semester, mProdi.nama_prodi')
            ->join('mMonev', 'mMonev.id = laporan_monev.fk_monev')
            ->join('setting_periode', 'setting_periode.id = laporan_monev.fk_setting_periode')
            ->join('mProdi', 'mProdi.id = laporan_monev.fk_prodi', 'left');
    }


    public function getLaporanByProdi($kodeProdi)
    {
        return $this->_getBaseQuery()
            ->where('laporan_monev.fk_prodi', $kodeProdi)

            ->orderBy('laporan_monev.create_at', 'DESC')
            ->findAll();
    }

    // 3. Fungsi Detail jadi sangat pendek
    public function getLaporanDetail($id)
    {
        return $this->_getBaseQuery()->find($id);
    }
}
