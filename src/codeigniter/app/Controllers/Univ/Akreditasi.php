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
        // 1. AMBIL STATUS
        $status = $this->request->getPost('tahap');

        // 2. SETTING VALIDASI
        $rules = [
            // [WAJIB] Admin Univ harus pilih Prodi
            'fk_prodi'        => 'required',

            // Sisanya dibuat OPSIONAL (permit_empty)
            'fk_lembaga'      => 'permit_empty',
            'tahun'           => 'permit_empty|numeric',
            'tahap'           => 'permit_empty',
            'ts'              => 'permit_empty|numeric',
            'ts_1'            => 'permit_empty|numeric',
            'ts_2'            => 'permit_empty|numeric',
        ];

        // Validasi Tambahan (Tetap permit_empty agar konsisten)
        if ($status == 'Selesai') {
            $rules['peringkat']      = 'permit_empty';
            $rules['fk_lembaga_internasional'] = 'permit_empty';
            $rules['nilai']          = 'permit_empty|numeric';
            $rules['no_sk']          = 'permit_empty';
            $rules['tgl_kadaluarsa'] = 'permit_empty|valid_date';
            $rules['link']           = 'permit_empty|valid_url';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }


        $getPost = function ($field) {
            $val = $this->request->getPost($field);
            return ($val === '' || $val === null) ? null : $val;
        };

        // 3. PERSIAPAN DATA
        $dataSimpan = [
            'fk_user'  => session()->get('current_user_id'),

            // [WAJIB] Ambil langsung karena required
            'fk_prodi' => $this->request->getPost('fk_prodi'),

            // [OPSIONAL] Gunakan helper $getPost
            'fk_lembaga_akreditasi'    => $getPost('fk_lembaga'),
            'fk_lembaga_internasional' => $getPost('fk_lembaga_internasional'),
            'tahun_penyusunan'         => $getPost('tahun'),

            // Biaya default 0
            'biaya'                    => $this->request->getPost('biaya') ?: 0,

            // Tahap pengajuan (bisa null jika tidak ada di view)
            'tahap_pengajuan'          => $getPost('tahap_pengajuan'),
            'tahap'                    => $status,

            // Data TS
            'ts'   => $getPost('ts'),
            'ts-1' => $getPost('ts_1'),
            'ts-2' => $getPost('ts_2'),
        ];

        // 4. FILTER DATA (LOGIKA SELESAI)
        if ($status == 'Selesai') {
            $dataSimpan['peringkat']        = $getPost('peringkat');

            $valNilai = $this->request->getPost('nilai');
            $dataSimpan['nilai']            = empty($valNilai) ? 0 : $valNilai;

            $dataSimpan['no_sk_akreditasi'] = $getPost('no_sk');
            $dataSimpan['tgl_kadaluarsa']   = $getPost('tgl_kadaluarsa');
            $dataSimpan['link_sertifikat']  = $getPost('link');
        } else {
            $dataSimpan['peringkat']        = null;
            $dataSimpan['nilai']            = 0;
            $dataSimpan['no_sk_akreditasi'] = null;
            $dataSimpan['tgl_kadaluarsa']   = null;
            $dataSimpan['link_sertifikat']  = $getPost('link');
        }

        // 5. Simpan ke Database
        $this->akreditasiModel->save($dataSimpan);

        return redirect()->to('univ/monitoring/akreditasi')->with('message', 'Data akreditasi prodi berhasil ditambahkan!');
    }
}
