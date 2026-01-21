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
        // Kita join dengan tabel periode agar bisa menampilkan Tahun/Semester di tabel
        $db = \Config\Database::connect();
        $builder = $db->table('mMonev');
        $builder->select('mMonev.*, setting_periode.tahun_akademik, setting_periode.semester');
        $builder->join('setting_periode', 'setting_periode.id = mMonev.fk_setting_periode');
        $query = $builder->get();

        $data = [
            'title'    => 'Master Item Monev',
            'username' => session()->get('username'),
            'monev'    => $query->getResultArray(),
            'periode'  => $this->periodeModel->findAll() // Untuk dropdown di modal
        $data = [
            'title'    => 'Master Item Monev',
            'username' => session()->get('username'),
            'monev'    => $this->monevModel->findAll()
        ];
        return view('univ/monev/index', $data);
    }

    public function simpan()
    {
        $this->monevModel->insert([
            'fk_setting_periode' => $this->request->getPost('fk_setting_periode'),
            'nama_monev'         => $this->request->getPost('nama_monev'),
            'keterangan'         => $this->request->getPost('keterangan'),
            'status'             => 1
            'nama_monev' => $this->request->getPost('nama_monev'),
            'status'     => 1 // Default aktif
        ]);
        return redirect()->back()->with('success', 'Item Monev berhasil ditambahkan!');
    }

    public function edit()
    {
        $id = $this->request->getPost('id');
        $this->monevModel->update($id, [
            'fk_setting_periode' => $this->request->getPost('fk_setting_periode'),
            'nama_monev'         => $this->request->getPost('nama_monev'),
            'keterangan'         => $this->request->getPost('keterangan'),
            'status'             => $this->request->getPost('status')
            'nama_monev' => $this->request->getPost('nama_monev'),
            'status'     => $this->request->getPost('status')
        ]);
        return redirect()->back()->with('success', 'Item Monev berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $this->monevModel->delete($id);
        return redirect()->back()->with('success', 'Item Monev berhasil dihapus!');
    }
}