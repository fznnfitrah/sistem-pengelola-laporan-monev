<?php

namespace App\Controllers\Prodi;

use App\Controllers\BaseController;
use App\Models\AkreditasiModel;
use App\Models\LembagaAkreditasiModel;

class Akreditasi extends BaseController
{
    protected $akreditasiModel;
    protected $lembagaModel;

    public function __construct()
    {
        $this->akreditasiModel = new AkreditasiModel();
        $this->lembagaModel    = new LembagaAkreditasiModel();
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
            'lembaga'    => $this->lembagaModel->findAll(), // Mengambil data untuk Dropdown
            'validation' => \Config\Services::validation()
        ];

        return view('prodi/akreditasi/akreditasi_add_view', $data);
    }

    // --- FITUR BARU: PROSES SIMPAN ---
    public function create()
    {
        // 1. Validasi Input
        if (!$this->validate([
            'fk_lembaga'     => 'required',
            'peringkat'      => 'required',
            'no_sk'          => 'required',
            'tgl_sk'         => 'required|valid_date',
            'tgl_kadaluarsa' => 'required|valid_date',
            'tahun'          => 'required|numeric',
            'link'           => 'required|valid_url',
        ])) {
            // Jika salah, kembalikan ke form dengan pesan error
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // 2. Siapkan Data
        $dataSimpan = [
            'fk_user'               => session()->get('current_user_id'), // Siapa yang input (dari session login)
            'fk_prodi'              => session()->get('fk_prodi'),        // Prodi milik user
            'fk_lembaga_akreditasi' => $this->request->getPost('fk_lembaga'),
            'peringkat'             => $this->request->getPost('peringkat'),
            'nilai'                 => $this->request->getPost('nilai'),
            'no_sk_akreditasi'      => $this->request->getPost('no_sk'),
            'tgl_sk_keluar'         => $this->request->getPost('tgl_sk'),
            'tgl_kadaluarsa'        => $this->request->getPost('tgl_kadaluarsa'),
            'tahun_penyusunan'      => $this->request->getPost('tahun'),
            'biaya'                 => $this->request->getPost('biaya'),
            'tahap_pengajuan'       => $this->request->getPost('tahap_pengajuan'), // TS-1, TS-2
            'tahap'                 => $this->request->getPost('tahap'), // Persiapan, Selesai
            'link_sertifikat'       => $this->request->getPost('link'),
        ];

        // 3. Simpan ke Database (Insert baru, jadi datanya menumpuk/history)
        $this->akreditasiModel->save($dataSimpan);

        return redirect()->to('prodi/akreditasi/akreditasi_view')->with('message', 'Data akreditasi berhasil ditambahkan!');
    }
}
