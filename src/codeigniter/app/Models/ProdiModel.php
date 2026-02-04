<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdiModel extends Model
{
    protected $table = 'mProdi'; // Sesuai database kamu
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false; // Karena varchar(20)
    protected $allowedFields = [
        'id',
        'fk_fakultas',
        'nama_prodi',
        'fk_jenjang',
        'no_sk_pendirian',
        'tgl_sk_pendirian',
        'link_sk_pendirian',
    ];

    public function getProdiByFakultas($idFakultas)
    {
        return $this->select('mProdi.*, mJenjang.jenjang') 
            ->join('mJenjang', 'mJenjang.id = mProdi.fk_jenjang', 'left') 
            ->where('mProdi.fk_fakultas', $idFakultas)
            ->orderBy('mJenjang.id', 'ASC') 
            ->orderBy('mProdi.nama_prodi', 'ASC') 
            ->findAll();
    }

    
}
