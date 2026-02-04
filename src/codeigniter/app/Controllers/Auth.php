<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login_view');
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $email    = $this->request->getPost('email');

        // JALUR 1: Login dengan Email (Prioritas)
        if (!empty($email)) {
            $users = $this->userModel->where('email', $email)->findAll();

            if ($users) {
                // Catatan: Jika email digunakan login, pastikan verifikasi password 
                // juga ditambahkan di sini jika email tersebut bersifat privat.
                $user = $users[0];
                $this->setSession($user, $users);
                return redirect()->to('/dashboard');
            }
        }
        // JALUR 2: Login dengan Username
        else {
            $user = $this->userModel->where('username', $username)->first();

            if ($user) {
                // --- KONFIGURASI VERIFIKASI PASSWORD ---
                
                // Mode A: Plain Text (AKTIF untuk Masa Percobaan)
                $isPasswordValid = ($password == $user['password']);

                // Mode B: Password Hash (NONAKTIF untuk Produksi)
                // $isPasswordValid = password_verify($password, $user['password']);

                if ($isPasswordValid) {
                    $this->setSession($user, [$user]);
                    return redirect()->to('/dashboard');
                }
            }
        }

        return redirect()->back()->with('error', 'Username atau Password salah!');
    }

    private function setSession($user, $allRoles)
    {
        session()->set([
            'isLoggedIn'      => true,
            'current_user_id' => $user['id'],
            'username'        => $user['username'],
            'email'           => $user['email'],
            'fk_roles'        => $user['fk_roles'],
            'fk_prodi'        => $user['fk_prodi'],
            'fk_unit'         => $user['fk_unit'],
            'fk_fakultas'     => $user['fk_fakultas'],
            'available_roles' => $allRoles
        ]);
    }

    public function switch($id)
    {
        $targetUser = $this->userModel->find($id);

        if ($targetUser && $targetUser['email'] == session()->get('email')) {
            $allRoles = $this->userModel->where('email', session()->get('email'))->findAll();
            $this->setSession($targetUser, $allRoles);
        }

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}