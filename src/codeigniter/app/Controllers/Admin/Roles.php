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
            return redirect()->to('/admin/roles/add')->withInput()->with('errors', $this->validator->getErrors());;
        }

        $this->roleModel->save([
            'nama_roles' => $this->request->getPost('nama_roles'), // Sesuai kolom DB
            'deskripsi'  => $this->request->getPost('deskripsi'),  // Sesuai kolom DB
        ]);

        return redirect()->to('/admin/roles')->with('message', 'Role berhasil ditambahkan!');
    }

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

    public function edit($id = null)
    {
        $dataRole = $this->roleModel->find($id);

        if (!$dataRole) {
            return redirect()->to('/admin/roles')->with('error', 'Data role tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Role',
            'validation' => \Config\Services::validation(),
            'role' => $dataRole // Kirim data role ke view
        ];

        return view('admin/roles/edit_roles_view', $data);
    }

    public function update($id = null)
    {
        // Validasi
        if (!$this->validate([
            'nama_roles' => [
                'rules'  => "required|is_unique[roles.nama_roles,id,{$id}]",
                'errors' => [
                    'required'  => 'Nama Role wajib diisi.',
                    'is_unique' => 'Nama Role sudah ada, gunakan nama lain.'
                ]
            ],
            'deskripsi' => [
                'rules'  => 'permit_empty|max_length[255]',
                'errors' => [
                    'max_length' => 'Deskripsi terlalu panjang.'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Proses Upda
        $this->roleModel->update($id, [
            'nama_roles' => $this->request->getPost('nama_roles'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
        ]);

        return redirect()->to('/admin/roles')->with('message', 'Role berhasil diperbarui!');
    }
}
