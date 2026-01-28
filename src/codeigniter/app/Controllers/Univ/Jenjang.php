<?php

namespace App\Controllers\Univ;

use App\Controllers\BaseController;
use App\Models\JenjangModel;

class Jenjang extends BaseController
{
    protected $jenjangModel;

    public function __construct()
    {
        $this->jenjangModel = new JenjangModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Master Jenjang Prodi',
            'jenjang' => $this->jenjangModel->findAll()
        ];
        return view('univ/jenjang/index', $data);
    }

    public function simpan()
    {
        $this->jenjangModel->save([
            'jenjang'    => $this->request->getPost('jenjang'),
            'keterangan' => $this->request->getPost('keterangan')
        ]);
        return redirect()->to('univ/jenjang')->with('message', 'Data jenjang berhasil disimpan.');
    }

    public function edit()
    {
        $id = $this->request->getPost('id');
        $this->jenjangModel->update($id, [
            'jenjang'    => $this->request->getPost('jenjang'),
            'keterangan' => $this->request->getPost('keterangan')
        ]);
        return redirect()->to('univ/jenjang')->with('message', 'Data jenjang berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $this->jenjangModel->delete($id);
        return redirect()->to('univ/jenjang')->with('message', 'Data jenjang berhasil dihapus.');
    }
}