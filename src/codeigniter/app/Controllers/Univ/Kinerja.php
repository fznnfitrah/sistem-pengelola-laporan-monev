<?php

namespace App\Controllers\Univ;

use App\Controllers\BaseController;
use App\Models\KinerjaModel;

class Kinerja extends BaseController
{
    protected $kinerjaModel;

    public function __construct()
    {
        $this->kinerjaModel = new KinerjaModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Master Indikator Kinerja',
            'username' => session()->get('username'),
            'kinerja'  => $this->kinerjaModel->findAll()
        ];
        return view('univ/kinerja/index', $data);
    }

    public function simpan()
    {
        $this->kinerjaModel->insert([
            'nama_kinerja'  => $this->request->getPost('nama_kinerja'),
            'jenis'         => $this->request->getPost('jenis'), // prodi/unit
            'satuan'        => $this->request->getPost('satuan'),
            'standar_nilai' => $this->request->getPost('standar_nilai'), // Kolom baru
            'status'        => 1 // Default aktif
        ]);
        return redirect()->back()->with('success', 'Data kinerja berhasil ditambahkan!');
    }

    public function edit()
    {
        $id = $this->request->getPost('id');
        $this->kinerjaModel->update($id, [
            'nama_kinerja'  => $this->request->getPost('nama_kinerja'),
            'jenis'         => $this->request->getPost('jenis'),
            'satuan'        => $this->request->getPost('satuan'),
            'standar_nilai' => $this->request->getPost('standar_nilai'),
            'status'        => $this->request->getPost('status') // Bisa di non-aktifkan
        ]);
        return redirect()->back()->with('success', 'Data kinerja berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $this->kinerjaModel->delete($id);
        return redirect()->back()->with('success', 'Indikator berhasil dihapus!');
    }
}