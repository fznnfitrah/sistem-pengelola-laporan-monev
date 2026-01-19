<?php

namespace App\Controllers\Univ;

use App\Controllers\BaseController;
use App\Models\UnitModel;

class Unit extends BaseController
{
    protected $unitModel;

    public function __construct()
    {
        $this->unitModel = new UnitModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Kelola Unit & Lembaga',
            'username' => session()->get('username'),
            'mUnit'    => $this->unitModel->findAll()
        ];
        return view('univ/unit/index', $data);
    }

    public function simpan()
    {
        $this->unitModel->insert([
            'id'        => strtoupper($this->request->getPost('id')),
            'nama_unit' => $this->request->getPost('nama_unit')
        ]);
        return redirect()->back()->with('success', 'Unit berhasil ditambahkan!');
    }

    public function edit()
    {
        $id_lama = $this->request->getPost('id_lama');
        $this->unitModel->update($id_lama, [
            'id'        => strtoupper($this->request->getPost('id')),
            'nama_unit' => $this->request->getPost('nama_unit')
        ]);
        return redirect()->back()->with('success', 'Data unit berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $this->unitModel->delete($id);
        return redirect()->back()->with('success', 'Unit berhasil dihapus!');
    }
}