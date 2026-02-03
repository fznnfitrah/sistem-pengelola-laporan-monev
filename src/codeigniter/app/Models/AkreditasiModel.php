<?php

namespace App\Models;

use CodeIgniter\Model;

class AkreditasiModel extends Model
{
    protected $table            = 'akreditasi_prodi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'fk_user',
        'fk_prodi',
        'fk_lembaga_akreditasi',
        'fk_lembaga_internasional',
        'nilai',
        'peringkat',
        'no_sk_akreditasi',
        'tgl_sk_keluar',
        'tgl_kadaluarsa',
        'tahun_penyusunan',
        'biaya',
        'status',
        'ts',
        'ts-1',
        'ts-2',
        'link_sertifikat',
        'tahap',
    ];


    protected $useTimestamps = true;
    protected $createdField  = 'create_at';
    protected $updatedField  = 'update_at';


    public function getRiwayat($kodeProdi = null)
    {
        $builder = $this->select('
                akreditasi_prodi.*, 
                mProdi.nama_prodi, 
                mJenjang.jenjang, 
                
                L1.nama_lembaga as nama_lembaga,

                L2.nama_lembaga as nama_lembaga_internasional, 

                user.username as penginput
            ')
            ->join('mProdi', 'mProdi.id = akreditasi_prodi.fk_prodi')
            ->join('mJenjang', 'mJenjang.id = mProdi.fk_jenjang', 'left')
            ->join('mLembaga_akreditasi as L1', 'L1.id = akreditasi_prodi.fk_lembaga_akreditasi', 'left')
            ->join('mLembaga_akreditasi as L2', 'L2.id = akreditasi_prodi.fk_lembaga_internasional', 'left')
            ->join('user', 'user.id = akreditasi_prodi.fk_user');

        if ($kodeProdi != null) {
            $builder->where('akreditasi_prodi.fk_prodi', $kodeProdi);
        }

        return $builder->orderBy('akreditasi_prodi.tgl_sk_keluar', 'DESC')->findAll();
    }


    public function getLatestAkreditasiAll()
    {
        return $this->select('
                akreditasi_prodi.*, 
                mProdi.nama_prodi, 
                mFakultas.nama_fakultas, 
                mJenjang.jenjang, 
                L1.nama_lembaga as nama_lembaga_nasional, 
                L2.nama_lembaga as nama_lembaga_internasional,
                user.username as penginput
            ')
            ->join('mProdi', 'mProdi.id = akreditasi_prodi.fk_prodi')
            ->join('mFakultas', 'mFakultas.id = mProdi.fk_fakultas')
            ->join('mJenjang', 'mJenjang.id = mProdi.fk_jenjang', 'left')
            ->join('mLembaga_akreditasi as L1', 'L1.id = akreditasi_prodi.fk_lembaga_akreditasi', 'left')
            ->join('mLembaga_akreditasi as L2', 'L2.id = akreditasi_prodi.fk_lembaga_internasional', 'left')
            ->join('user', 'user.id = akreditasi_prodi.fk_user')
            ->whereIn('akreditasi_prodi.id', function ($builder) {
                return $builder->select('MAX(id)')->from('akreditasi_prodi')->groupBy('fk_prodi');
            })
            ->orderBy('mFakultas.nama_fakultas', 'ASC')
            ->findAll();
    }


    public function getRekapSemuaProdi()
    {
        return $this->db->table('mProdi')
            ->select('
                mProdi.nama_prodi, 
                mProdi.id as prodi_id,
                mProdi.no_sk_pendirian,
                mProdi.tgl_sk_pendirian,
                
                mJenjang.jenjang, 
                mFakultas.nama_fakultas,
                
                akreditasi_prodi.peringkat,
                akreditasi_prodi.nilai,
                akreditasi_prodi.no_sk_akreditasi,
                akreditasi_prodi.tgl_kadaluarsa,
                akreditasi_prodi.biaya,
                akreditasi_prodi.tahap,
                akreditasi_prodi.tahun_penyusunan,
                akreditasi_prodi.ts,
                akreditasi_prodi.ts-1,
                akreditasi_prodi.ts-2,
                akreditasi_prodi.link_sertifikat,
                
                // JOIN 1: Nasional
                L1.nama_lembaga as nama_lembaga,
                L1.jenis_lembaga,

                // JOIN 2: Internasional
                L2.nama_lembaga as nama_lembaga_inter_text
            ')
            ->join('mFakultas', 'mFakultas.id = mProdi.fk_fakultas')
            ->join('mJenjang', 'mJenjang.id = mProdi.fk_jenjang', 'left')

            ->join('(SELECT * FROM akreditasi_prodi WHERE id IN (SELECT MAX(id) FROM akreditasi_prodi GROUP BY fk_prodi)) as akreditasi_prodi', 'akreditasi_prodi.fk_prodi = mProdi.id', 'left')

            ->join('mLembaga_akreditasi as L1', 'L1.id = akreditasi_prodi.fk_lembaga_akreditasi', 'left')
            ->join('mLembaga_akreditasi as L2', 'L2.id = akreditasi_prodi.fk_lembaga_internasional', 'left')

            ->orderBy('mFakultas.nama_fakultas', 'ASC')
            ->get()->getResultArray();
    }
}
