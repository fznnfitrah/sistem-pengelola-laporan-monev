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
            'roles' => $this->roleModel->orderBy('nama_roles', 'ASC')->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/roles/index_roles_view', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'nama_roles' => [
                'rules'  => 'required|is_unique[roles.nama_roles]',
                'errors' => [
                    'required'  => 'Nama Role wajib diisi.',
                    'is_unique' => 'Nama Role sudah ada.'
                ]
            ],
            'deskripsi' => 'permit_empty|max_length[255]'
        ])) {
            return redirect()->to('/admin/roles')->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->roleModel->save([
            'nama_roles' => $this->request->getPost('nama_roles'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
        ]);

        return redirect()->to('/admin/roles')->with('message', 'Role berhasil ditambahkan!');
    }

    public function update($id = null)
    {
        if (!$this->validate([
            'nama_roles' => [
                'rules'  => "required|is_unique[roles.nama_roles,id,{$id}]",
                'errors' => [
                    'required'  => 'Nama Role wajib diisi.',
                    'is_unique' => 'Nama Role sudah ada.'
                ]
            ],
            'deskripsi' => 'permit_empty|max_length[255]'
        ])) {
            return redirect()->to('/admin/roles')->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->roleModel->update($id, [
            'nama_roles' => $this->request->getPost('nama_roles'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
        ]);

        return redirect()->to('/admin/roles')->with('message', 'Role berhasil diperbarui!');
    }

    public function delete($id = null)
    {
        if ($id == 1) {
            return redirect()->back()->with('message', 'Role Admin Utama tidak boleh dihapus!');
        }
        $this->roleModel->delete($id);
        return redirect()->to('/admin/roles')->with('message', 'Role berhasil dihapus!');
    }
}