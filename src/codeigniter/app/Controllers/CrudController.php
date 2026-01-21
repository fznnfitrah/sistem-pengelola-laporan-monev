<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

/**
 * Base CRUD Controller untuk mengurangi redundansi code
 * 
 * Extend class ini untuk CRUD operations yang standardized
 */
abstract class CrudController extends BaseController
{
    /**
     * Model yang digunakan
     */
    protected $model;

    /**
     * Path untuk redirect (misal: '/admin/roles')
     */
    protected $routePath = '';

    /**
     * Path view untuk list (misal: 'admin/roles/index')
     */
    protected $listViewPath = '';

    /**
     * Path view untuk add (misal: 'admin/roles/add')
     */
    protected $addViewPath = '';

    /**
     * Path view untuk edit (misal: 'admin/roles/edit')
     */
    protected $editViewPath = '';

    /**
     * Nama entity (misal: 'Role', 'User')
     */
    protected $entityName = '';

    /**
     * Validation rules untuk CREATE
     */
    protected function getCreateValidationRules(): array
    {
        return [];
    }

    /**
     * Validation rules untuk UPDATE
     */
    protected function getUpdateValidationRules($id): array
    {
        return [];
    }

    /**
     * Get data dari request untuk save/insert
     */
    protected function getDataFromRequest(): array
    {
        return [];
    }

    /**
     * Get data dari request untuk update
     */
    protected function getUpdateDataFromRequest($id): array
    {
        return $this->getDataFromRequest();
    }

    /**
     * List all items
     */
    public function index(): string
    {
        $data = [
            'title' => "Daftar {$this->entityName}",
            'items' => $this->model->findAll()
        ];

        return view($this->listViewPath, $data);
    }

    /**
     * Show add form
     */
    public function add(): string
    {
        $data = [
            'title'      => "Tambah {$this->entityName} Baru",
            'validation' => \Config\Services::validation()
        ];

        return view($this->addViewPath, $data);
    }

    /**
     * Save new item
     */
    public function save(): ResponseInterface
    {
        if (!$this->validate($this->getCreateValidationRules())) {
            return redirect()->to("{$this->routePath}/add")
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->model->save($this->getDataFromRequest());

        return redirect()->to($this->routePath)
            ->with('message', "{$this->entityName} berhasil ditambahkan!");
    }

    /**
     * Show edit form
     */
    public function edit($id = null): ResponseInterface|string
    {
        $item = $this->model->find($id);

        if (!$item) {
            return redirect()->to($this->routePath)
                ->with('error', "{$this->entityName} tidak ditemukan.");
        }

        $data = [
            'title'      => "Edit {$this->entityName}",
            'item'       => $item,
            'validation' => \Config\Services::validation()
        ];

        return view($this->editViewPath, $data);
    }

    /**
     * Update existing item
     */
    public function update($id = null): ResponseInterface
    {
        if (!$this->validate($this->getUpdateValidationRules($id))) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, $this->getUpdateDataFromRequest($id));

        return redirect()->to($this->routePath)
            ->with('message', "{$this->entityName} berhasil diperbarui!");
    }

    /**
     * Delete item with safety check
     */
    public function delete($id = null): ResponseInterface
    {
        if (!$this->model->find($id)) {
            return redirect()->back()
                ->with('error', "{$this->entityName} tidak ditemukan.");
        }

        $this->model->delete($id);

        return redirect()->to($this->routePath)
            ->with('message', "{$this->entityName} berhasil dihapus!");
    }

    /**
     * Helper: Get null-safe value dari request
     */
    protected function getNullSafeValue(string $fieldName): ?string
    {
        $value = $this->request->getPost($fieldName);
        return empty($value) ? null : $value;
    }

    /**
     * Helper: Get multiple values dengan null safety
     */
    protected function getNullSafeValues(array $fieldNames): array
    {
        $result = [];
        foreach ($fieldNames as $fieldName) {
            $result[$fieldName] = $this->getNullSafeValue($fieldName);
        }
        return $result;
    }
}
