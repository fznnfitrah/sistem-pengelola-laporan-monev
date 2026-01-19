<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoleModel;

class Roles extends BaseController
{
    protected $roleModel;

    public function __construct()
    {
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Daftar Roles',
            'roles' => $this->roleModel->findAll()
        ];
        return view('admin/roles/index_roles_view', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'Tambah Role Baru',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/roles/add_roles_view', $data);
    }

    public function save()
    {
        // Validasi Input
        if (!$this->validate([
            'nama_roles' => [
                'rules'  => 'required|is_unique[roles.nama_roles]',
                'errors' => [
                    'required'  => 'Nama Role wajib diisi.',
                    'is_unique' => 'Nama Role sudah ada, gunakan nama lain.'
                ]
            ],
            'deskripsi' => [
                'rules'  => 'permit_empty|max_length[255]',
                'errors' => [
                    'max_length' => 'Deskripsi terlalu panjang (maks 255 karakter).'
                ]
            ]
        ])) {
            // Jika validasi gagal, kembalikan ke form dengan input sebelumnya
            return redirect()->to('/admin/roles/add')->withInput()->with('errors', $this->validator->getErrors());;
        }

        // Simpan ke Database
        $this->roleModel->save([
            'nama_roles' => $this->request->getPost('nama_roles'), // Sesuai kolom DB
            'deskripsi'  => $this->request->getPost('deskripsi'),  // Sesuai kolom DB
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->to('/admin/roles')->with('message', 'Role berhasil ditambahkan!');
    }

    // Method delete tetap sama, hanya cara panggilannya dari route yang berbeda
    public function delete($id = null)
    {
        // Proteksi Role Admin Utama (ID 1)
        if ($id == 1) {
             return redirect()->back()->with('error', 'Role Admin Utama tidak boleh dihapus!');
        }

        // Cek apakah data ada sebelum hapus (opsional tapi disarankan)
        if (!$this->roleModel->find($id)) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Proses Hapus
        $this->roleModel->delete($id);

        return redirect()->to('/admin/roles')->with('message', 'Role berhasil dihapus!');
    }
}
