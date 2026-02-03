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

        // B. SETTING VALIDASI (SEMUA DIBUAT OPTIONAL / PERMIT_EMPTY)
        $rules = [
            'fk_lembaga'      => 'permit_empty',
            'tahun'           => 'permit_empty|numeric',
            'tahap'           => 'permit_empty',
            'tahap_pengajuan' => 'permit_empty',
            'ts'              => 'permit_empty|numeric',
            'ts_1'            => 'permit_empty|numeric',
            'ts_2'            => 'permit_empty|numeric',
        ];

        // Validasi Tambahan: Hapus 'required' jika ingin benar-benar optional
        if ($status == 'Selesai') {
            // Ubah 'required' jadi 'permit_empty' agar sesuai request (bisa kosong)
            $rules['peringkat']      = 'permit_empty';
            $rules['nilai']          = 'permit_empty|numeric';
            $rules['no_sk']          = 'permit_empty';
            $rules['tgl_kadaluarsa'] = 'permit_empty|valid_date';
            $rules['link']           = 'permit_empty|valid_url';
        }

        // C. JALANKAN VALIDASI
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // --- HELPER KHUSUS: UBAH STRING KOSONG JADI NULL ---
        // Ini kuncinya agar tidak error "Incorrect integer value"
        $getPost = function ($field) {
            $val = $this->request->getPost($field);
            return ($val === '' || $val === null) ? null : $val;
        };

        // D. PERSIAPAN DATA
        $dataSimpan = [
            // Hanya 2 ini yang WAJIB (diambil dari session)
            'fk_user'  => session()->get('current_user_id'),
            'fk_prodi' => session()->get('fk_prodi'),

            // Gunakan helper $getPost(...) untuk data yang boleh kosong
            'fk_lembaga_akreditasi'    => $getPost('fk_lembaga'),
            'fk_lembaga_internasional' => $getPost('fk_lembaga_internasional'),
            'tahun_penyusunan'         => $getPost('tahun'),

            // Biaya: Jika kosong anggap 0, atau pakai $getPost('biaya') jika mau NULL
            'biaya'                    => $this->request->getPost('biaya') ?: 0,

            'tahap_pengajuan'          => $getPost('tahap_pengajuan'),
            'tahap'                    => $getPost('tahap'),

            // Data TS
            'ts'   => $getPost('ts'),
            'ts-1' => $getPost('ts_1'),
            'ts-2' => $getPost('ts_2'),
        ];

        // E. FILTER DATA (LOGIKA SELESAI)
        if ($status == 'Selesai') {
            $dataSimpan['peringkat']        = $getPost('peringkat');

            // Logic nilai: jika kosong jadi 0 (atau null jika mau)
            $valNilai = $this->request->getPost('nilai');
            $dataSimpan['nilai']            = empty($valNilai) ? 0 : $valNilai;

            $dataSimpan['no_sk_akreditasi'] = $getPost('no_sk');
            $dataSimpan['tgl_kadaluarsa']   = $getPost('tgl_kadaluarsa');
            $dataSimpan['link_sertifikat']  = $getPost('link');
        } else {
            // Jika belum selesai, kosongkan/null-kan
            $dataSimpan['peringkat']        = null;
            $dataSimpan['nilai']            = 0;
            $dataSimpan['no_sk_akreditasi'] = null;
            $dataSimpan['tgl_kadaluarsa']   = null;
            $dataSimpan['link_sertifikat']  = $getPost('link');
        }

        // 3. Simpan
        $this->akreditasiModel->save($dataSimpan);

        return redirect()->to('prodi/akreditasi/index')->with('message', 'Data akreditasi berhasil ditambahkan!');
    }
}
