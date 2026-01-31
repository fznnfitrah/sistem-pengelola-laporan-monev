<?php

namespace App\Controllers\Univ;

use App\Controllers\BaseController;
use App\Models\AkreditasiModel; // Pastikan Model ini sudah ada
use App\Models\ProdiModel;      // Model untuk mengambil daftar Prodi
use App\Models\LembagaAkreditasiModel; // Model untuk data lembaga

class Akreditasi extends BaseController
{
    protected $akreditasiModel;
    protected $prodiModel;
    protected $lembagaModel;

    public function __construct()
    {
        $this->akreditasiModel = new AkreditasiModel();
        $this->prodiModel      = new ProdiModel();
        $this->lembagaModel    = new LembagaAkreditasiModel();
    }

    // --- HALAMAN FORM INPUT (KHUSUS UNIV) ---
    public function input()
    {
        // 1. Ambil Semua Prodi (Untuk Dropdown Pilihan)
        $dataProdi = $this->prodiModel
            ->select('mProdi.id, mProdi.nama_prodi, mJenjang.jenjang')
            ->join('mJenjang', 'mJenjang.id = mProdi.fk_jenjang', 'left')
            ->orderBy('mProdi.nama_prodi', 'ASC')
            ->findAll();

        // 2. Ambil Data Lembaga (Untuk Dropdown Lembaga & Biaya)
        $dataLembaga = $this->lembagaModel->findAll();

        $data = [
            'title'   => 'Input Data Akreditasi (Admin Univ)',
            'prodi'   => $dataProdi,   // Dikirim ke View
            'lembaga' => $dataLembaga, // Dikirim ke View
            'validation' => \Config\Services::validation()
        ];

        return view('univ/akreditasi/input_akreditasi', $data);
    }

    // --- PROSES SIMPAN DATA ---
    public function simpan()
    {
        // 1. Ambil Status
        $status = $this->request->getPost('tahap'); 

        // 2. Setting Validasi
        $rules = [
            'fk_prodi'        => 'required', // <--- PENTING: Univ Wajib Pilih Prodi
            'fk_lembaga'      => 'required',
            'tahun'           => 'required|numeric',
            'tahap'           => 'required', 
            // Validasi TS
            'ts'   => 'required|numeric', 
            'ts_1' => 'required|numeric',
            'ts_2' => 'required|numeric',
        ];

        // Validasi Tambahan jika Selesai
        if ($status == 'Selesai') {
            $rules['peringkat']      = 'required';
            $rules['nilai']          = 'required|numeric';
            $rules['no_sk']          = 'required';
            $rules['tgl_sk']         = 'required|valid_date';
            $rules['tgl_kadaluarsa'] = 'required|valid_date';
            $rules['link']           = 'required|valid_url';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // 3. Persiapan Data
        $dataSimpan = [
            'fk_user'               => session()->get('current_user_id'),
            
            // PERBEDAAN UTAMA: Ambil ID Prodi dari Input Form (Bukan Session)
            'fk_prodi'              => $this->request->getPost('fk_prodi'), 
            
            'fk_lembaga_akreditasi' => $this->request->getPost('fk_lembaga'),
            'tahun_penyusunan'      => $this->request->getPost('tahun'),
            'biaya'                 => $this->request->getPost('biaya'),
            'status'       => $this->request->getPost('status'), // TS-1 dll (jika ada input hidden)
            'tahap'                 => $status,
            
            // Data TS
            'ts'   => $this->request->getPost('ts'),
            'ts_1' => $this->request->getPost('ts_1'),
            'ts_2' => $this->request->getPost('ts_2'),
        ];

        // 4. Filter Data (Bersihkan jika belum selesai)
        if ($status == 'Selesai') {
            $dataSimpan['peringkat']        = $this->request->getPost('peringkat');
            $dataSimpan['nilai']            = $this->request->getPost('nilai');
            $dataSimpan['no_sk_akreditasi'] = $this->request->getPost('no_sk');
            $dataSimpan['tgl_sk_keluar']    = $this->request->getPost('tgl_sk');
            $dataSimpan['tgl_kadaluarsa']   = $this->request->getPost('tgl_kadaluarsa');
            $dataSimpan['link_sertifikat']  = $this->request->getPost('link');
        } else {
            $dataSimpan['peringkat']        = null; 
            $dataSimpan['nilai']            = 0;    
            $dataSimpan['no_sk_akreditasi'] = null; 
            $dataSimpan['tgl_sk_keluar']    = null; 
            $dataSimpan['tgl_kadaluarsa']   = null; 
            $dataSimpan['link_sertifikat']  = $this->request->getPost('link'); 
        }

        // 5. Simpan ke Database
        $this->akreditasiModel->save($dataSimpan);

        // Redirect ke halaman monitoring atau history univ
        return redirect()->to('univ/monitoring')->with('success', 'Data akreditasi prodi berhasil ditambahkan!');
    }
}