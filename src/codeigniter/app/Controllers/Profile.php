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

    // --- HALAMAN UTAMA (MENAMPILKAN SEMUA DATA) ---
    public function index()
    {
        $userId = session()->get('current_user_id');

        // WAJIB JOIN: Agar di halaman profil muncul "Perpustakaan", "Teknik Informatika", dll.
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
            'title' => 'Profil Saya',
            'user'  => $userData
        ];

        return view('profile/profile_view', $data);
    }

    // --- HALAMAN EDIT (HANYA YANG BOLEH DIUBAH) ---
    public function edit()
    {
        $userId = session()->get('current_user_id');

        // Cukup ambil data user biasa (tanpa join), karena di form edit kita tidak menampilkan prodi/unit
        $data = [
            'title'      => 'Edit Profil Saya',
            'user'       => $this->userModel->find($userId),
            'validation' => \Config\Services::validation()
        ];

        return view('profile/profile_edit_view', $data);
    }

    // --- PROSES UPDATE (LOGIKA PENYIMPANAN) ---
    public function update()
    {
        $userId = session()->get('current_user_id');

        $rules = [
            'username' => 'required|min_length[3]',
            'email'    => 'required|valid_email',
            'password' => 'permit_empty|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $updateData = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ];

        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            $updateData['password'] = $newPassword;
        }

        $this->userModel->update($userId, $updateData);

        // Update session username agar navbar langsung berubah
        session()->set(['username' => $updateData['username']]);

        return redirect()->to('/profile')->with('message', 'Profil berhasil diperbaharui!');
    }
}
