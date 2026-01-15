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

        if ($roleId == 1) {
            return view('dashboard/admin_view');
        } elseif ($roleId == 2) {
            return view('dashboard/fakultas_view');
        } elseif ($roleId == 3) {
            return view('dashboard/prodi_view');
        }
    }
}