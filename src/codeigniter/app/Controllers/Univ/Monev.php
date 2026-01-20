<?php

namespace App\Controllers\Univ;

use App\Controllers\BaseController;
use App\Models\MonevModel;

class Monev extends BaseController
{
    protected $monevModel;

    public function __construct()
    {
        $this->monevModel = new MonevModel();
    }

    public function index()
    {
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
            'nama_monev' => $this->request->getPost('nama_monev'),
            'status'     => 1 // Default aktif
        ]);
        return redirect()->back()->with('success', 'Item Monev berhasil ditambahkan!');
    }

    public function edit()
    {
        $id = $this->request->getPost('id');
        $this->monevModel->update($id, [
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