<?php

namespace App\Controllers\Univ;

use App\Controllers\BaseController;
use App\Models\LembagaAkreditasiModel;

class LembagaAkreditasi extends BaseController
{
    protected $lembagaModel;

    public function __construct()
    {
        $this->lembagaModel = new LembagaAkreditasiModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Master Lembaga Akreditasi',
            'lembaga' => $this->lembagaModel->findAll()
        ];
        return view('univ/lembaga_akreditasi/index', $data);
    }

    public function simpan()
    {
        $this->lembagaModel->save([
            'nama_lembaga'  => $this->request->getPost('nama_lembaga'),
            'jenis_lembaga' => $this->request->getPost('jenis_lembaga'),
            'biaya'         => $this->request->getPost('biaya'),
            'url'           => $this->request->getPost('url'),
            'alamat'        => $this->request->getPost('alamat'),
        ]);
        return redirect()->to('univ/lembaga_akreditasi')->with('message', 'Lembaga akreditasi berhasil ditambahkan.');
    }

    public function edit()
    {
        $id = $this->request->getPost('id');
        $this->lembagaModel->update($id, [
            'nama_lembaga'  => $this->request->getPost('nama_lembaga'),
            'jenis_lembaga' => $this->request->getPost('jenis_lembaga'),
            'biaya'         => $this->request->getPost('biaya'),
            'url'           => $this->request->getPost('url'),
            'alamat'        => $this->request->getPost('alamat'),
        ]);
        return redirect()->to('univ/lembaga_akreditasi')->with('message', 'Data lembaga berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $this->lembagaModel->delete($id);
        return redirect()->to('univ/lembaga_akreditasi')->with('message', 'Lembaga berhasil dihapus.');
    }
}