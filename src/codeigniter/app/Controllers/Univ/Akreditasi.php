<?php

namespace App\Controllers\Univ;

use App\Controllers\BaseController;
use App\Models\AkreditasiModel;
use App\Models\ProdiModel;
use App\Models\LembagaAkreditasiModel;

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
            'prodi'   => $dataProdi,
            'lembaga' => $dataLembaga,
            'validation' => \Config\Services::validation()
        ];

        return view('univ/akreditasi/input_akreditasi_view', $data);
    }

    // --- PROSES SIMPAN DATA ---
    public function simpan()
    {
        // 1. Ambil Status (Selesai/Persiapan/dll)
        $status = $this->request->getPost('tahap');

        // 2. Setting Validasi
        $rules = [
            'fk_prodi'        => 'required',
            'fk_lembaga'      => 'required',
            'tahun'           => 'required|numeric',
            'tahap'           => 'required',

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

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // 3. Persiapan Data Dasar
        $dataSimpan = [
            'fk_user'               => session()->get('current_user_id'),
            'fk_prodi'              => $this->request->getPost('fk_prodi'),
            'fk_lembaga_akreditasi' => $this->request->getPost('fk_lembaga'),

            'fk_lembaga_internasional' => $this->request->getPost('fk_lembaga_internasional'),

            'tahun_penyusunan'      => $this->request->getPost('tahun'),
            'biaya'                 => $this->request->getPost('biaya'),

            // [KOREKSI] Ubah 'status' jadi 'tahap_pengajuan' sesuai input hidden di View
            'tahap_pengajuan'       => $this->request->getPost('tahap_pengajuan'),

            'tahap'                 => $status, // Persiapan, Selesai, dll

            // Data TS
            'ts'   => $this->request->getPost('ts'),
            'ts-1' => $this->request->getPost('ts_1'),
            'ts-2' => $this->request->getPost('ts_2'),
        ];

        // 4. Filter Data (Khusus Status Selesai)
        if ($status == 'Selesai') {
            $dataSimpan['peringkat']        = $this->request->getPost('peringkat');

            $inputNilai = $this->request->getPost('nilai');
            $dataSimpan['nilai']            = empty($inputNilai) ? 0 : $inputNilai;

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

        // 5. Simpan ke Database

        $this->akreditasiModel->save($dataSimpan);

        return redirect()->to('univ/monitoring/akreditasi')->with('success', 'Data akreditasi prodi berhasil ditambahkan!');
    }
}
