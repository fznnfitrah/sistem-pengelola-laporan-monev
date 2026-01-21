<?php

namespace App\Controllers;

/**
 * Auth Controller - REFACTORED dengan Security Improvements
 * 
 * - Menggunakan password_verify() untuk password validation
 * - Menambahkan input validation
 * - Menambahkan type hints
 */
class AuthRefactored extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
    }

    public function index(): string|\CodeIgniter\HTTP\ResponseInterface
    {
        // Cek jika sudah login, lempar ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login_view');
    }

    public function login(): \CodeIgniter\HTTP\ResponseInterface
    {
        // VALIDASI INPUT TERLEBIH DAHULU
        if (!$this->validate([
            'email' => 'permit_empty|valid_email',
            'username' => 'permit_empty|required_without[email]',
            'password' => 'required|min_length[6]'
        ])) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $email = $this->request->getPost('email');

        // JALUR 1: Login dengan Email (Prioritas)
        if (!empty($email)) {
            $users = $this->userModel->where('email', $email)->findAll();

            if ($users) {
                $user = $users[0];
                // GUNAKAN password_verify() - LEBIH AMAN
                if (password_verify($password, $user['password'])) {
                    $this->setSession($user, $users);
                    return redirect()->to('/dashboard');
                }
            }
        }
        // JALUR 2: Login dengan Username
        else {
            $user = $this->userModel->where('username', $username)->first();

            // GUNAKAN password_verify() - LEBIH AMAN
            if ($user && password_verify($password, $user['password'])) {
                $this->setSession($user, [$user]);
                return redirect()->to('/dashboard');
            }
        }

        return redirect()->back()
            ->with('error', 'Username/Email atau Password salah!');
    }

    private function setSession(array $user, array $allRoles): void
    {
        session()->set([
            'isLoggedIn'      => true,
            'current_user_id' => $user['id'],
            'username'        => $user['username'],
            'email'           => $user['email'],
            'fk_roles'        => $user['fk_roles'],
            'fk_prodi'        => $user['fk_prodi'],
            'fk_unit'         => $user['fk_unit'],
            'available_roles' => $allRoles
        ]);
    }

    public function switch($id): \CodeIgniter\HTTP\ResponseInterface
    {
        $targetUser = $this->userModel->find($id);

        if ($targetUser && $targetUser['email'] == session()->get('email')) {
            $allRoles = $this->userModel->where('email', session()->get('email'))->findAll();
            $this->setSession($targetUser, $allRoles);
        }

        return redirect()->to('/dashboard');
    }

    public function logout(): \CodeIgniter\HTTP\ResponseInterface
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
