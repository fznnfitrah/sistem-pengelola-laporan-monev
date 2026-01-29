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
            'mUnit'    => $this->unitModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('univ/unit/master_unit_view', $data);
    }

    public function simpan()
    {
        // 1. TAMBAHAN: Cek Validasi Dulu
        if (!$this->validate([
            'id' => [
                'rules'  => 'required|is_unique[mUnit.id]',
                'errors' => [
                    'required'  => 'Kode Unit wajib diisi.',
                    'is_unique' => 'Gagal! Kode Unit tersebut sudah terdaftar.'
                ]
            ],
            'nama_unit' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. TAMBAHAN: Try-Catch (Jaring Pengaman Terakhir)
        try {
            $this->unitModel->insert([
                'id'        => strtoupper($this->request->getPost('id')),
                'nama_unit' => $this->request->getPost('nama_unit')
            ]);
            return redirect()->back()->with('success', 'Unit berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('errors', ['database' => 'Gagal menyimpan: Kode Unit mungkin duplikat.']);
        }
    }

    public function edit()
    {
        $id_lama = $this->request->getPost('id_lama');
        $id_baru = strtoupper($this->request->getPost('id'));

        // 3. TAMBAHAN: Cek Manual saat Edit
        if ($id_lama != $id_baru) {
            $cek = $this->unitModel->find($id_baru);
            if ($cek) {
                return redirect()->back()->withInput()->with('errors', ['id' => 'Gagal Update! ID Unit sudah digunakan.']);
            }
        }

        try {
            $this->unitModel->update($id_lama, [
                'id'        => $id_baru,
                'nama_unit' => $this->request->getPost('nama_unit')
            ]);
            return redirect()->back()->with('success', 'Data unit berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('errors', ['database' => 'Gagal update database.']);
        }
    }

    public function hapus($id)
    {
        try {
            $this->unitModel->delete($id);
            return redirect()->back()->with('success', 'Unit berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('errors', ['database' => 'Gagal menghapus! Unit ini mungkin masih terkait data lain.']);
        }
    }
}
