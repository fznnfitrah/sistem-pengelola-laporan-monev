<?php

namespace App\Controllers;

use App\Models\UserModel; // Panggil Modelnya

class Auth extends BaseController
{
    public function index()
    {
        return view('auth/login_view');
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $email    = $this->request->getPost('email');

        $userModel = new \App\Models\UserModel();

        // JALUR 1: Jika User mengisi Email (Multi-Role)
        if (!empty($email)) {
            $users = $userModel->where('email', $email)->findAll();
            if ($users) {
                $user = $users[0]; // Ambil akun pertama sebagai default
                $this->setSession($user, $users);
                return redirect()->to('/dashboard');
            }
        } 
        // JALUR 2: Jika User mengisi Username & Password (Single Role)
        else {
            $user = $userModel->where('username', $username)->first();
            if ($user && $password == $user['password']) {
                $this->setSession($user, [$user]);
                return redirect()->to('/dashboard');
            }
        }

        return redirect()->back()->with('error', 'Kombinasi login salah!');
    }

    private function setSession($user, $allRoles)
    {
        session()->set([
            'isLoggedIn'      => true,
            'current_user_id' => $user['id'],
            'username'        => $user['username'],
            'email'           => $user['email'],
            'fk_roles'        => $user['fk_roles'],
            'fk_fakultas'     => $user['fk_fakultas'], // varchar
            'fk_prodi'        => $user['fk_prodi'],    // varchar
            'available_roles' => $allRoles            // Untuk Switch Role di Topbar
        ]);
    }
    public function switch($id)
    {
        $userModel = new \App\Models\UserModel();
        $targetUser = $userModel->find($id);

        // Pastikan user yang dipilih punya email yang sama dengan session aktif
        if ($targetUser && $targetUser['email'] == session()->get('email')) {
            session()->set([
                'current_user_id' => $targetUser['id'],
                'fk_roles'        => $targetUser['fk_roles'],
                'fk_fakultas'     => $targetUser['fk_fakultas'],
                'fk_prodi'        => $targetUser['fk_prodi'],
            ]);
        }

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}