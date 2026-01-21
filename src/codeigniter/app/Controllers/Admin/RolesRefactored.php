<?php

namespace App\Controllers\Admin;

use App\Controllers\CrudController;
use App\Models\RoleModel;
use App\Validation\RoleValidation;

/**
 * Roles Controller - REFACTORED dengan CrudController
 * 
 * Menggunakan base CRUD controller untuk mengurangi redundansi code
 */
class RolesRefactored extends CrudController
{
    protected $model;
    protected $routePath = '/admin/roles';
    protected $listViewPath = 'admin/roles/index_roles_view';
    protected $addViewPath = 'admin/roles/add_roles_view';
    protected $editViewPath = 'admin/roles/edit_roles_view';
    protected $entityName = 'Role';

    public function __construct()
    {
        $this->model = new RoleModel();
    }

    protected function getCreateValidationRules(): array
    {
        return RoleValidation::createRules();
    }

    protected function getUpdateValidationRules($id): array
    {
        return RoleValidation::updateRules($id);
    }

    protected function getDataFromRequest(): array
    {
        return [
            'nama_roles' => $this->request->getPost('nama_roles'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
        ];
    }

    /**
     * Override delete untuk proteksi Role Admin
     */
    public function delete($id = null)
    {
        // Proteksi Role Admin Utama (ID 1)
        if ($id == 1) {
            return redirect()->back()
                ->with('error', 'Role Admin Utama tidak boleh dihapus!');
        }

        // Gunakan parent delete method
        return parent::delete($id);
    }
}
