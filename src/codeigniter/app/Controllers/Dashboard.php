<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        // Cek apakah user sudah login atau belum
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $roleId = session()->get('fk_roles');
        $username = session()->get('username');

        $data = [
            'title' => 'Dashboard',
            'roleId' => $roleId,
            'username' => $username
        ];

        return view('dashboard/dashboard_view', $data);
    }
}
