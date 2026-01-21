<?php

namespace App\Validation;

/**
 * Validation Rules untuk Role
 * 
 * Centralized validation rules untuk menghindari duplikasi
 */
class RoleValidation
{
    /**
     * Get validation rules untuk create/update
     * 
     * @param bool $isUpdate Apakah ini untuk update?
     * @param int|null $id ID untuk exclude pada is_unique
     * @return array Validation rules
     */
    public static function rules(bool $isUpdate = false, ?int $id = null): array
    {
        $uniqueRule = 'required|is_unique[roles.nama_roles]';
        if ($isUpdate && $id !== null) {
            $uniqueRule = "required|is_unique[roles.nama_roles,id,{$id}]";
        }

        return [
            'nama_roles' => [
                'rules'  => $uniqueRule,
                'errors' => [
                    'required'  => 'Nama Role wajib diisi.',
                    'is_unique' => 'Nama Role sudah ada, gunakan nama lain.'
                ]
            ],
            'deskripsi' => [
                'rules'  => 'permit_empty|max_length[255]',
                'errors' => [
                    'max_length' => 'Deskripsi terlalu panjang (maks 255 karakter).'
                ]
            ]
        ];
    }

    /**
     * Get rules untuk create only
     */
    public static function createRules(): array
    {
        return self::rules(false);
    }

    /**
     * Get rules untuk update only
     */
    public static function updateRules(int $id): array
    {
        return self::rules(true, $id);
    }
}
