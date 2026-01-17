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
            'title'    => 'Dashboard',
            'roleId'   => $roleId,
            'username' => $username,
            // Tambahkan ini agar bisa dipanggil di view
            'unitCode' => ($roleId == 2) ? session()->get('fk_fakultas') : session()->get('fk_prodi')
        ];

        return view('dashboard/dashboard_view', $data);
    }
}
