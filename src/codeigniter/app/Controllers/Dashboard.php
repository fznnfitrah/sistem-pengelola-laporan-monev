<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
       
        // Ambil role dari session
        $roleId = session()->get('fk_roles');

        // Logika pengalihan view sesuai role
        if ($roleId == 1) {
            return view('dashboard/admin_view');
        } elseif ($roleId == 2) {
            return view('dashboard/fakultas_view');
        } elseif ($roleId == 3) {
            return view('dashboard/prodi_view'); // Memanggil file yang berisi 3 card tadi
        }

        // Jika tidak ada session, lempar ke login
        return redirect()->to('/login');
    }
}