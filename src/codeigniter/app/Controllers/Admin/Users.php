<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\FakultasModel;
use App\Models\ProdiModel;
use App\Models\UnitModel;

class Users extends BaseController
{
    protected $userModel;
    protected $roleModel;
    protected $fakultasModel;
    protected $prodiModel;
    protected $unitModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        $this->fakultasModel = new FakultasModel();
        $this->prodiModel = new ProdiModel();
        $this->unitModel = new UnitModel();
    }

    public function index()
    {
        $data = [
            'title'         => 'Kelola Pengguna',
            'users'         => $this->userModel->getAllUsersWithRelations(),
            'roles'         => $this->roleModel->orderBy('nama_roles', 'ASC')->findAll(),
            'data_fakultas' => $this->fakultasModel->orderBy('nama_fakultas', 'ASC')->findAll(),
            'data_prodi'    => $this->prodiModel->orderBy('nama_prodi', 'ASC')->findAll(),
            'data_unit'     => $this->unitModel->orderBy('id', 'ASC')->findAll(),
            'validation'    => \Config\Services::validation()
        ];

        return view('admin/users/index_users_view', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'username' => [
                'rules'  => 'required|is_unique[user.username]|min_length[4]',
                'errors' => ['is_unique' => 'Username sudah terdaftar.']
            ],
            'email'    => [
                'rules'  => "permit_empty|valid_email",
                'errors' => ['valid_email' => 'Format email tidak valid.']
            ],
            'password' => 'required|min_length[6]',
            'fk_roles' => 'required',
        ])) {
            return redirect()->to('/admin/users')->withInput()->with('errors', $this->validator->getErrors());
        }

        $fkFakultas = $this->request->getPost('fk_fakultas');
        $fkProdi    = $this->request->getPost('fk_prodi');
        $fkUnit     = $this->request->getPost('fk_unit');


        $passwordRaw = $this->request->getPost('password');
        
        $passwordFinal = $passwordRaw;
        // $passwordFinal = password_hash($passwordRaw, PASSWORD_DEFAULT); // <--- NONAKTIF (Enkripsi untuk Produksi)

        $this->userModel->save([
            'username'    => $this->request->getPost('username'),
            'email'       => $this->request->getPost('email'),
            'password'    => $passwordFinal,
            'fk_roles'    => $this->request->getPost('fk_roles'),
            'fk_fakultas' => (empty($fkFakultas)) ? null : $fkFakultas,
            'fk_prodi'    => (empty($fkProdi))    ? null : $fkProdi,
            'fk_unit'     => (empty($fkUnit))     ? null : $fkUnit,
            'status'      => $this->request->getPost('status'),
        ]);

        return redirect()->to('/admin/users')->with('message', 'User berhasil ditambahkan!');
    }

    public function update($id = null)
    {
        if (!$this->validate([
            'username' => [
                'rules'  => "required|min_length[4]|is_unique[user.username,id,{$id}]",
                'errors' => ['is_unique' => 'Username sudah digunakan user lain.']
            ],
            'email'    => [
                'rules'  => "permit_empty|valid_email",
                'errors' => ['valid_email' => 'Format email tidak valid.']
            ],
            'password' => 'permit_empty|min_length[6]',
            'fk_roles' => 'required',
        ])) {
            return redirect()->to('/admin/users')->withInput()->with('errors', $this->validator->getErrors());
        }

        $fkFakultas = $this->request->getPost('fk_fakultas');
        $fkProdi    = $this->request->getPost('fk_prodi');
        $fkUnit     = $this->request->getPost('fk_unit');

        $updateData = [
            'username'    => $this->request->getPost('username'),
            'email'       => $this->request->getPost('email'),
            'fk_roles'    => $this->request->getPost('fk_roles'),
            'fk_fakultas' => (empty($fkFakultas)) ? null : $fkFakultas,
            'fk_prodi'    => (empty($fkProdi))    ? null : $fkProdi,
            'fk_unit'     => (empty($fkUnit))     ? null : $fkUnit,
            'status'      => $this->request->getPost('status'),
        ];

        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            // Pilih salah satu:
            $updateData['password'] = $newPassword; 
            // $updateData['password'] = password_hash($newPassword, PASSWORD_DEFAULT); // <--- NONAKTIF (Enkripsi)
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to('/admin/users')->with('message', 'Data user berhasil diperbarui!');
    }

    public function delete($id = null)
    {
        if (!$this->userModel->find($id)) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $this->userModel->delete($id);
        return redirect()->to('/admin/users')->with('message', 'User berhasil dihapus!');
    }
}