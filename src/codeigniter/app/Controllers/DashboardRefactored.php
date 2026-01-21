<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use App\Constants\RoleConstants;

/**
 * Dashboard Controller - REFACTORED
 * 
 * Menggunakan RoleConstants untuk menggantikan magic numbers
 */
class DashboardRefactored extends BaseController
{
    public function index(): string|ResponseInterface
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

        // Gunakan RoleConstants untuk mapping
        $dashboardView = RoleConstants::getDashboardView($roleId);
        $unitField = RoleConstants::getUnitCodeField($roleId);

        if ($unitField) {
            $data['unitCode'] = session()->get($unitField);
        }

        return view($dashboardView, $data);
    }
}
