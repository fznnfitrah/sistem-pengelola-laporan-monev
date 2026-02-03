<?php

namespace App\Controllers\Prodi;

use App\Controllers\BaseController;
use App\Models\AkreditasiModel;
use App\Models\LembagaAkreditasiModel;

class Akreditasi extends BaseController
{
    protected $akreditasiModel;
    protected $lembagaAkreditasiModel;

    public function __construct()
    {
        $this->akreditasiModel = new AkreditasiModel();
        $this->lembagaAkreditasiModel = new LembagaAkreditasiModel();
    }

    public function index()
    {
        $kodeProdi = session()->get('fk_prodi');

        $data = [
            'title'     => 'Riwayat Akreditasi Prodi',
            'riwayat'   => $this->akreditasiModel->getRiwayat($kodeProdi)
        ];

        return view('prodi/akreditasi/akreditasi_view', $data);
    }

    // --- FITUR BARU: HALAMAN TAMBAH DATA ---
    public function new()
    {
        $data = [
            'title'      => 'Input Akreditasi Baru',
            'lembaga'    => $this->lembagaAkreditasiModel->findAll(), // Mengambil data untuk Dropdown
            'validation' => \Config\Services::validation()
        ];

        return view('prodi/akreditasi/input_akreditasi_view', $data);
    }

    public function simpan()
    {
        // A. AMBIL STATUS
        $status = $this->request->getPost('tahap');

        // B. SETTING VALIDASI DINAMIS
        $rules = [
            'fk_lembaga'      => 'required',
            'tahun'           => 'required|numeric',
            'tahap'           => 'required',
            'tahap_pengajuan' => 'required',
            'ts'   => 'required|numeric',
            'ts_1' => 'required|numeric',
            'ts_2' => 'required|numeric',
        ];

        // Validasi Tambahan jika Selesai
        if ($status == 'Selesai') {
            $rules['peringkat']      = 'required';

            $rules['fk_lembaga_internasional'] = 'permit_empty';
            
            $rules['nilai']          = 'permit_empty|numeric';
            $rules['no_sk']          = 'required';
            $rules['tgl_kadaluarsa'] = 'required|valid_date';
            $rules['link']           = 'permit_empty|valid_url';
        }

        // C. JALANKAN VALIDASI
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // D. PERSIAPAN DATA
        $dataSimpan = [
            'fk_user'               => session()->get('current_user_id'),
            'fk_prodi'              => session()->get('fk_prodi'),

            'fk_lembaga_akreditasi' => $this->request->getPost('fk_lembaga'),

            'fk_lembaga_internasional' => $this->request->getPost('fk_lembaga_internasional'),

            'tahun_penyusunan'      => $this->request->getPost('tahun'),
            'biaya'                 => $this->request->getPost('biaya'),
            'tahap_pengajuan'       => $this->request->getPost('tahap_pengajuan'),
            'tahap'                 => $status,

            // Data TS
            'ts'   => $this->request->getPost('ts'),
            'ts-1' => $this->request->getPost('ts_1'),
            'ts-2' => $this->request->getPost('ts_2'),
        ];

        // E. FILTER DATA (DATA CLEANING)
        if ($status == 'Selesai') {
            $dataSimpan['peringkat']        = $this->request->getPost('peringkat');

            // Logic agar nilai 0 tersimpan jika kosong
            $valNilai = $this->request->getPost('nilai');
            $dataSimpan['nilai']            = empty($valNilai) ? 0 : $valNilai;

            $dataSimpan['no_sk_akreditasi'] = $this->request->getPost('no_sk');
            $dataSimpan['tgl_kadaluarsa']   = $this->request->getPost('tgl_kadaluarsa');
            $dataSimpan['link_sertifikat']  = $this->request->getPost('link');
        } else {
            $dataSimpan['peringkat']        = null;
            $dataSimpan['nilai']            = 0;
            $dataSimpan['no_sk_akreditasi'] = null;
            $dataSimpan['tgl_kadaluarsa']   = null;
            $dataSimpan['link_sertifikat']  = $this->request->getPost('link');
        }

        // 3. Simpan
        // dd($dataSimpan); // Hapus atau komentari ini jika sudah benar
        $this->akreditasiModel->save($dataSimpan);

        return redirect()->to('prodi/akreditasi/index')->with('message', 'Data akreditasi berhasil ditambahkan!');
    }
}
