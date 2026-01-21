<?php

namespace App\Constants;

/**
 * Role Constants - Definisikan semua role ID dan properties
 * 
 * Gunakan ini untuk menggantikan magic numbers di code
 */
class RoleConstants
{
    public const ADMIN = 1;
    public const FAKULTAS = 2;
    public const PRODI = 3;
    public const UNIT = 4;
    public const UNIVERSITAS = 5;

    /**
     * Mapping Role ID ke View Path
     */
    public const DASHBOARD_VIEWS = [
        self::ADMIN       => 'admin/dashboard_view',
        self::FAKULTAS    => 'fakultas/dashboard_view',
        self::PRODI       => 'prodi/dashboard_view',
        self::UNIT        => 'unit/dashboard_view',
        self::UNIVERSITAS => 'univ/dashboard_view',
    ];

    /**
     * Mapping Role ID ke Session Field yang berisi unit code
     * null jika role tidak memiliki unit code
     */
    public const UNIT_CODE_FIELDS = [
        self::ADMIN       => null,
        self::FAKULTAS    => 'fk_fakultas',
        self::PRODI       => 'fk_prodi',
        self::UNIT        => 'fk_unit',
        self::UNIVERSITAS => null,
    ];

    /**
     * Role Names untuk display
     */
    public const ROLE_NAMES = [
        self::ADMIN       => 'Administrator',
        self::FAKULTAS    => 'Dekan/Pimpinan Fakultas',
        self::PRODI       => 'Ketua Program Studi',
        self::UNIT        => 'Kepala Unit/Lembaga',
        self::UNIVERSITAS => 'Pimpinan Universitas',
    ];

    /**
     * Get dashboard view untuk role
     */
    public static function getDashboardView(int $roleId): string
    {
        return self::DASHBOARD_VIEWS[$roleId] ?? 'dashboard/dashboard_view';
    }

    /**
     * Get unit code field untuk role
     */
    public static function getUnitCodeField(int $roleId): ?string
    {
        return self::UNIT_CODE_FIELDS[$roleId] ?? null;
    }

    /**
     * Get role name untuk display
     */
    public static function getRoleName(int $roleId): string
    {
        return self::ROLE_NAMES[$roleId] ?? 'Unknown Role';
    }

    /**
     * Check apakah role memiliki unit code
     */
    public static function hasUnitCode(int $roleId): bool
    {
        return !is_null(self::getUnitCodeField($roleId));
    }
}
