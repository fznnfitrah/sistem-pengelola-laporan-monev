<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $roleId = session()->get('fk_roles');
        $data = [
            'title'    => 'Dashboard',
            'username' => session()->get('username'),
            'roleId'   => $roleId
        ];

        // Jalur render view berdasarkan folder role masing-masing
        switch ($roleId) {
            case 1: // ADMIN
                return view('admin/dashboard_view', $data);
            case 2: // FAKULTAS
                $data['unitCode'] = session()->get('fk_fakultas');
                return view('fakultas/dashboard_view', $data);
            case 3: // PRODI
                $data['unitCode'] = session()->get('fk_prodi');
                return view('prodi/dashboard_view', $data);
            case 4: // UNIT / LEMBAGA (TAMBAHKAN INI)
                $data['unitCode'] = session()->get('fk_unit'); 
                return view('unit/dashboard_view', $data);
            case 5: // UNIVERSITAS
                return view('univ/dashboard_view', $data);
            default:
                return view('dashboard/dashboard_view', $data); // Fallback
        }
    }
}