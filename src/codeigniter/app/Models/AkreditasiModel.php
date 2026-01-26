<?php

namespace App\Models;

use CodeIgniter\Model;

class AkreditasiModel extends Model
{
    protected $table            = 'akreditasi_prodi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Pastikan semua nama kolom di sini sama persis dengan di database
    protected $allowedFields    = [
        'fk_user', 
        'fk_prodi', 
        'fk_lembaga_akreditasi', 
        'nilai', 
        'peringkat', // Pastikan kolom ini sudah ditambahkan di DB
        'no_sk_akreditasi', 
        'tgl_sk_keluar', 
        'tgl_kadaluarsa', 
        'tahun_penyusunan', 
        'biaya', 
        'tahap_pengajuan', // TS-1, TS-2, dll
        'link_sertifikat', 
        'tahap' // Persiapan, Pengajuan, dll
    ];

    // Mengaktifkan fitur timestamp otomatis (create_at & update_at)
    protected $useTimestamps = true;
    protected $createdField  = 'create_at';
    protected $updatedField  = 'update_at';

    /**
     * Fungsi custom untuk mengambil data lengkap dengan Nama Prodi & Lembaga
     */
    public function getRiwayat($kodeProdi = null)
    {
        // Start Query
        $builder = $this->select('akreditasi_prodi.*, 
                                  mProdi.nama_prodi, 
                                  mJenjang.jenjang, 
                                  mLembaga_akreditasi.nama_lembaga,
                                  user.username as penginput')
                        ->join('mProdi', 'mProdi.id = akreditasi_prodi.fk_prodi')
                        ->join('mJenjang', 'mJenjang.id = mProdi.fk_jenjang', 'left')
                        ->join('mLembaga_akreditasi', 'mLembaga_akreditasi.id = akreditasi_prodi.fk_lembaga_akreditasi')
                        ->join('user', 'user.id = akreditasi_prodi.fk_user');

        // Jika ada parameter kodeProdi, filter berdasarkan prodi tersebut
        if ($kodeProdi != null) {
            $builder->where('akreditasi_prodi.fk_prodi', $kodeProdi);
        }

        // Urutkan dari yang terbaru (berdasarkan tanggal SK)
        return $builder->orderBy('akreditasi_prodi.tgl_sk_keluar', 'DESC')
                       ->findAll();
    }

    // Fungsi untuk Universitas: Ambil akreditasi terbaru dari SETIAP prodi
    public function getLatestAkreditasiAll()
    {
        return $this->select('akreditasi_prodi.*, mProdi.nama_prodi, mFakultas.nama_fakultas, mFakultas.id as fakultas_id, mLembaga_akreditasi.nama_lembaga, mJenjang.jenjang, user.username as penginput')
            ->join('mProdi', 'mProdi.id = akreditasi_prodi.fk_prodi')
            ->join('mFakultas', 'mFakultas.id = mProdi.fk_fakultas')
            ->join('mJenjang', 'mJenjang.id = mProdi.fk_jenjang', 'left')
            ->join('mLembaga_akreditasi', 'mLembaga_akreditasi.id = akreditasi_prodi.fk_lembaga_akreditasi')
            ->join('user', 'user.id = akreditasi_prodi.fk_user')
            // Subquery untuk memastikan hanya mengambil ID terbaru (row terakhir) per Prodi
            ->whereIn('akreditasi_prodi.id', function($builder) {
                return $builder->select('MAX(id)')->from('akreditasi_prodi')->groupBy('fk_prodi');
            })
            ->orderBy('mFakultas.nama_fakultas', 'ASC')
            ->findAll();
    }
}