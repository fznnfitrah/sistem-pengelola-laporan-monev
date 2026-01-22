<?php

namespace App\Controllers\Univ;

use App\Controllers\BaseController;
use App\Models\MonevModel;
use App\Models\PeriodeModel;

class Monev extends BaseController
{
    protected $monevModel;
    protected $periodeModel;

    public function __construct()
    {
        $this->monevModel = new MonevModel();
        $this->periodeModel = new PeriodeModel();
    }

    public function index()
    {
        // Gabungkan tabel mMonev dengan setting_periode untuk mendapatkan teks Tahun & Semester
        $db = \Config\Database::connect();
        $builder = $db->table('mMonev');
        $builder->select('mMonev.*, setting_periode.tahun_akademik, setting_periode.semester');
        $builder->join('setting_periode', 'setting_periode.id = mMonev.fk_setting_periode');
        $query = $builder->get();

        $data = [
            'title'    => 'Master Item Monev',
            'username' => session()->get('username'),
            'monev'    => $query->getResultArray(),
            'periode'  => $this->periodeModel->findAll() // Data untuk dropdown di modal tambah/edit
        ];

        return view('univ/monev/index', $data);
    }

    public function simpan()
    {
        // Simpan data sesuai dengan kolom yang ada di database
        $this->monevModel->insert([
            'fk_setting_periode' => $this->request->getPost('fk_setting_periode'),
            'nama_monev'         => $this->request->getPost('nama_monev'),
            'keterangan'         => $this->request->getPost('keterangan'),
            'status'             => 1 // Default langsung aktif
        ]);

        return redirect()->back()->with('success', 'Item Monev berhasil ditambahkan!');
    }

    public function edit()
    {
        $id = $this->request->getPost('id');
        
        // Update data berdasarkan ID yang dikirim dari form
        $this->monevModel->update($id, [
            'fk_setting_periode' => $this->request->getPost('fk_setting_periode'),
            'nama_monev'         => $this->request->getPost('nama_monev'),
            'keterangan'         => $this->request->getPost('keterangan'),
            'status'             => $this->request->getPost('status')
        ]);

        return redirect()->back()->with('success', 'Item Monev berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $this->monevModel->delete($id);
        return redirect()->back()->with('success', 'Item Monev berhasil dihapus!');
    }
}