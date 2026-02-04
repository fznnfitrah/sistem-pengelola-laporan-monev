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
        'fk_fakultas',
        'fk_setting_periode',
        'fk_monev',
        'keterangan',
        'link_bukti',
        'create_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'create_at';
    protected $updatedField  = '';

    private function _getBaseQuery()
    {
        // Tambahkan join ke mFakultas agar nama fakultas muncul di detail
        return $this->select('laporan_monev.*, mMonev.nama_monev, setting_periode.tahun_akademik, setting_periode.semester, mProdi.nama_prodi, mFakultas.nama_fakultas, mUnit.nama_unit')
            ->join('mMonev', 'mMonev.id = laporan_monev.fk_monev')
            ->join('setting_periode', 'setting_periode.id = laporan_monev.fk_setting_periode')
            ->join('mFakultas', 'mFakultas.id = laporan_monev.fk_fakultas', 'left') 
            ->join('mProdi', 'mProdi.id = laporan_monev.fk_prodi', 'left')
            ->join('mUnit', 'mUnit.id = laporan_monev.fk_unit', 'left');
    }

    public function getProdiByFakultas($idFakultas)
    {
        return $this->select('mProdi.*, mJenjang.jenjang') 
            ->join('mJenjang', 'mJenjang.id = mProdi.fk_jenjang', 'left') 
            ->where('mProdi.fk_fakultas', $idFakultas)
            ->orderBy('mJenjang.id', 'ASC') // Opsional: Urutkan berdasarkan S1/D3 dst
            ->orderBy('mProdi.nama_prodi', 'ASC') 
            ->findAll();
    }

    public function getLaporanByProdi($kodeProdi)
    {
        return $this->_getBaseQuery()
            ->where('laporan_monev.fk_prodi', $kodeProdi)
            ->orderBy('laporan_monev.create_at', 'DESC')
            ->findAll();
    }

    public function getLaporanByFakultas($kodeFakultas)
    {
        return $this->_getBaseQuery()
            ->where('laporan_monev.fk_fakultas', $kodeFakultas)
            ->where('laporan_monev.fk_prodi', null) // Filter khusus fakultas
            ->orderBy('laporan_monev.create_at', 'DESC')
            ->findAll();
    }

    public function getLaporanByUnit($kodeUnit)
    {
        return $this->_getBaseQuery()
            ->where('laporan_monev.fk_unit', $kodeUnit)
            ->orderBy('laporan_monev.create_at', 'DESC')
            ->findAll();
    }

    public function getLaporanDetail($id)
    {
        return $this->_getBaseQuery()->find($id);
    }
    
}
