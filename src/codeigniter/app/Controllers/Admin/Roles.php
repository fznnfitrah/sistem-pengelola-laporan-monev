<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoleModel;

class Roles extends BaseController
{
    protected $roleModel;

    public function __construct()
    {
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Daftar Roles',
            'roles' => $this->roleModel->findAll()
        ];
        return view('admin/roles/index_roles_view', $data);
    }


}
