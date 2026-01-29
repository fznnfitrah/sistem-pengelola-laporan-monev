<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // --- HALAMAN UTAMA (VIEW & EDIT JADI SATU) ---
    public function index()
    {
        $userId = session()->get('current_user_id');

        // JOIN DATA LENGKAP
        $userData = $this->userModel
            ->select('user.*, mProdi.nama_prodi, mUnit.nama_unit, mFakultas.nama_fakultas, roles.nama_roles')
            ->join('mProdi', 'mProdi.id = user.fk_prodi', 'left')
            ->join('mUnit', 'mUnit.id = user.fk_unit', 'left')
            ->join('mFakultas', 'mFakultas.id = user.fk_fakultas', 'left')
            ->join('roles', 'roles.id = user.fk_roles', 'left')
            ->find($userId);

        if (!$userData) {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title'      => 'Profil Saya',
            'user'       => $userData,
            // Kirim validasi ke view untuk menangkap error input (jika ada)
            'validation' => \Config\Services::validation()
        ];

        return view('profile/profile_view', $data);
    }

    // --- PROSES UPDATE ---
    public function update()
    {
        $userId = session()->get('current_user_id');

        // Validasi input
        $rules = [
            'username' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'min_length' => 'Username minimal 3 karakter.'
                ]
            ],
            'email'    => [
                'rules' => 'permit_empty|valid_email',
                'errors' => [
                    'valid_email' => 'Format email tidak valid.'
                ]
            ],
            'password' => [
                'rules' => 'permit_empty|min_length[6]',
                'errors' => [
                    'min_length' => 'Password baru minimal 6 karakter.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            // Jika gagal, kembalikan ke halaman profile (index) dengan input & error
            return redirect()->to('/profile')->withInput()->with('validation', $this->validator);
        }

        // Siapkan data update
        $emailInput = $this->request->getPost('email');

        $updateData = [
            'username' => $this->request->getPost('username'),
            'email'    => empty($emailInput) ? null : $emailInput,
        ];

        // Cek apakah password diisi?
        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            // Sebaiknya di-hash (jika Anda menggunakan password_hash di sistem login)
            // $updateData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateData['password'] = $newPassword; // Sesuaikan dengan sistem hash Anda
        }

        $this->userModel->update($userId, $updateData);

        // Update session username agar navbar langsung berubah tanpa logout
        session()->set(['username' => $updateData['username']]);

        return redirect()->to('/profile')->with('message', 'Profil berhasil diperbaharui!');
    }
}
