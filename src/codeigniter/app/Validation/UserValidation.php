<?php

namespace App\Validation;

/**
 * Validation Rules untuk User
 * 
 * Centralized validation rules untuk menghindari duplikasi
 */
class UserValidation
{
    /**
     * Get validation rules untuk create
     */
    public static function createRules(): array
    {
        return [
            'username' => [
                'rules' => 'required|is_unique[user.username]|min_length[4]',
                'errors' => [
                    'required'   => 'Username wajib diisi.',
                    'is_unique'  => 'Username sudah terdaftar.',
                    'min_length' => 'Username minimal 4 karakter.'
                ]
            ],
            'email' => [
                'rules' => 'permit_empty|valid_email|is_unique[user.email]',
                'errors' => [
                    'valid_email' => 'Email tidak valid.',
                    'is_unique'   => 'Email sudah terdaftar.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required'   => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 6 karakter.'
                ]
            ],
            'fk_roles' => [
                'rules' => 'required',
                'errors' => ['required' => 'Role wajib dipilih.']
            ],
            'fk_fakultas' => 'permit_empty',
            'fk_prodi'    => 'permit_empty',
            'fk_unit'     => 'permit_empty',
            'status'      => 'permit_empty'
        ];
    }

    /**
     * Get validation rules untuk update
     */
    public static function updateRules(int $id): array
    {
        return [
            'username' => [
                'rules' => "required|min_length[4]|is_unique[user.username,id,{$id}]",
                'errors' => [
                    'required'   => 'Username wajib diisi.',
                    'is_unique'  => 'Username sudah digunakan user lain.',
                    'min_length' => 'Username minimal 4 karakter.'
                ]
            ],
            'email' => [
                'rules' => "permit_empty|valid_email|is_unique[user.email,id,{$id}]",
                'errors' => [
                    'valid_email' => 'Email tidak valid.',
                    'is_unique'   => 'Email sudah digunakan user lain.'
                ]
            ],
            'password' => [
                'rules' => 'permit_empty|min_length[6]',
                'errors' => [
                    'min_length' => 'Password minimal 6 karakter.'
                ]
            ],
            'fk_roles' => [
                'rules' => 'required',
                'errors' => ['required' => 'Role wajib dipilih.']
            ],
            'fk_fakultas' => 'permit_empty',
            'fk_prodi'    => 'permit_empty',
            'fk_unit'     => 'permit_empty',
            'status'      => 'permit_empty'
        ];
    }
}
