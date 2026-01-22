<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    // 1. Definisikan Property Model agar bisa diakses seluruh method
    protected $userModel;

    // 2. Inisialisasi Model di Constructor
    public function __construct()
    {
        $this->userModel  = new UserModel();
    }

    public function index()
    {
        // Cek jika sudah login, lempar ke dashboard
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
                // Ambil user pertama & simpan session
                $user = $users[0];
                $this->setSession($user, $users);
                return redirect()->to('/dashboard');
            }
        }
        // JALUR 2: Login dengan Username
        else {
            $user = $this->userModel->where('username', $username)->first();

            // Verifikasi Password (sementara plain text sesuai DB Anda)
            if ($user && $password == $user['password']) {
                $this->setSession($user, [$user]);
                return redirect()->to('/dashboard');
            }
        }

        return redirect()->back()->with('error', 'Username atau Password salah!');
    }

    private function setSession($user, $allRoles)
    {
        // Langsung set session:
        session()->set([
            'isLoggedIn'      => true,
            'current_user_id' => $user['id'],
            'username'        => $user['username'],
            'email'           => $user['email'],
            'fk_roles'        => $user['fk_roles'],

            // SIMPAN APA ADANYA (String "infor1", "teknik1", dll)
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
