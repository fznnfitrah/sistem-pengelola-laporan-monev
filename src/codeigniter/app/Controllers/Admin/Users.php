<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\FakultasModel;
use App\Models\ProdiModel;

class Users extends BaseController
{
    protected $userModel;
    protected $roleModel;
    protected $fakultasModel;
    protected $prodiModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        $this->fakultasModel = new FakultasModel();
        $this->prodiModel = new ProdiModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Pengguna',
            'users' => $this->userModel->getAllUsersWithRelations()
        ];

        return view('admin/users/index_users_view', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'Tambah User Baru',
            'roles' => $this->roleModel->findAll(), // Ambil semua role untuk dropdown

            'data_fakultas' => $this->fakultasModel->findAll(),
            'data_prodi'    => $this->prodiModel->findAll(),

            'validation' => \Config\Services::validation()
        ];

        return view('admin/users/add_users_view', $data);
    }

    public function save()
    {
        // Validasi
        if (!$this->validate([
            'username' => [
                'rules' => 'required|is_unique[user.username]|min_length[4]',
                'errors' => ['is_unique' => 'Username sudah terdaftar.']
            ],
            'email' => [
                'rules' => 'permit_empty|valid_email|is_unique[user.email]',
                'errors' => ['is_unique' => 'Email sudah terdaftar.']
            ],
            'password' => 'required|min_length[6]',
            'fk_roles' => 'required',

            'fk_fakultas' => 'permit_empty',
            'fk_prodi'    => 'permit_empty',
            'fk_unit'     => 'permit_empty',
        ])) {
            return redirect()->to('/admin/users/add')->withInput()->with('errors', $this->validator->getErrors());
        }

        $fkFakultas = $this->request->getPost('fk_fakultas');
        $fkProdi    = $this->request->getPost('fk_prodi');
        $fkUnit     = $this->request->getPost('fk_unit');

        // Simpan Data
        $this->userModel->save([
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'fk_roles' => $this->request->getPost('fk_roles'),

            // Logic konversi String Kosong "" menjadi NULL
            'fk_fakultas' => (empty($fkFakultas)) ? null : $fkFakultas,
            'fk_prodi'    => (empty($fkProdi))    ? null : $fkProdi,
            'fk_unit'     => (empty($fkUnit))     ? null : $fkUnit,

            'status'      => $this->request->getPost('status'),
        ]);

        return redirect()->to('/admin/users')->with('message', 'User berhasil ditambahkan!');
    }

    public function delete($id = null)
    {
        // Cek data user
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Proses Hapus
        $this->userModel->delete($id);

        return redirect()->to('/admin/users')->with('message', 'User berhasil dihapus!');
    }

    public function edit($id = null)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit User',
            'user'  => $user,
            'roles' => $this->roleModel->findAll(), // Untuk dropdown role

            'data_fakultas' => $this->fakultasModel->findAll(),
            'data_prodi'    => $this->prodiModel->findAll(),

            'validation' => \Config\Services::validation()
        ];

        return view('admin/users/edit_users_view', $data);
    }

    // 5. MEMPROSES UPDATE
    public function update($id = null)
    {
        // Validasi: Perhatikan rule 'is_unique' yang mengecualikan ID saat ini
        if (!$this->validate([
            'username' => [
                'rules' => "required|min_length[4]|is_unique[user.username,id,{$id}]",
                'errors' => ['is_unique' => 'Username sudah digunakan user lain.']
            ],
            'email' => [
                'rules' => "permit_empty|valid_email|is_unique[user.email,id,{$id}]",
                'errors' => ['is_unique' => 'Email sudah digunakan user lain.']
            ],
            // Password tidak wajib diisi saat edit (permit_empty)
            'password' => 'permit_empty|min_length[6]',
            'fk_roles' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Logic Input Foreign Key (Null Safety)
        $fkFakultas = $this->request->getPost('fk_fakultas');
        $fkProdi    = $this->request->getPost('fk_prodi');
        $fkUnit     = $this->request->getPost('fk_unit');

        // Data Dasar yang akan diupdate
        $updateData = [
            'username'    => $this->request->getPost('username'),
            'email'       => $this->request->getPost('email'),
            'fk_roles'    => $this->request->getPost('fk_roles'),
            'fk_fakultas' => (empty($fkFakultas)) ? null : $fkFakultas,
            'fk_prodi'    => (empty($fkProdi))    ? null : $fkProdi,
            'fk_unit'     => (empty($fkUnit))     ? null : $fkUnit,
            'status'      => $this->request->getPost('status'),
        ];

        // LOGIC PASSWORD: Hanya update jika input tidak kosong
        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            $updateData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        // Eksekusi Update
        $this->userModel->update($id, $updateData);

        return redirect()->to('/admin/users')->with('message', 'Data user berhasil diperbarui!');
    }
}
