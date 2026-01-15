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
        $userModel = new UserModel();
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan username
        $user = $userModel->where('username', $username)->first();

        if ($user) {
            // Cek password (karena di database kamu isi teks biasa, kita cek langsung)
            if ($password == $user['password']) {
                
                // Simpan data user ke Session
                session()->set([
                    'id_user'     => $user['id'],
                    'username'    => $user['username'],
                    'fk_roles'    => $user['fk_roles'], // Ini yang menentukan tampilan dashboard
                    'fk_fakultas' => $user['fk_fakultas'],
                    'fk_prodi'    => $user['fk_prodi'],
                    'isLoggedIn'  => true
                ]);

                return redirect()->to('/'); // Lempar ke Dashboard
            } else {
                return redirect()->to('/login')->with('error', 'Password Salah');
            }
        } else {
            return redirect()->to('/login')->with('error', 'Username Tidak Ditemukan');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}