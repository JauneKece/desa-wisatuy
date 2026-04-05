<?php

namespace App\Enums;

/**
 * User Role Enumeration
 * Single source of truth untuk semua role yang tersedia di sistem DESMOK
 * 
 * Updated: April 5, 2026 - Migration dari (manager, staff, customer) -> (owner, bendahara, pelanggan)
 */
class UserRole
{
    /**
     * Role Values - ENUM values di database
     */
    const ADMIN = 'admin';
    const OWNER = 'owner';              // Manager Operasional (formerly: manager)
    const BENDAHARA = 'bendahara';      // Staff Keuangan (formerly: staff)
    const PELANGGAN = 'pelanggan';      // Customer/Wisatawan (formerly: customer)

    /**
     * Role Labels - Display names untuk UI
     */
    const LABELS = [
        self::ADMIN => 'Administrator',
        self::OWNER => 'Pemilik/Manager',
        self::BENDAHARA => 'Bendahara/Keuangan',
        self::PELANGGAN => 'Pelanggan/Wisatawan',
    ];

    /**
     * Role Icons - Emoji icons untuk UI
     */
    const ICONS = [
        self::ADMIN => '👨‍💼',
        self::OWNER => '🏢',
        self::BENDAHARA => '💰',
        self::PELANGGAN => '👤',
    ];

    /**
     * Role Descriptions - Detailed descriptions untuk documentation
     */
    const DESCRIPTIONS = [
        self::ADMIN => 'Administrator Sistem - Akses penuh ke semua aspek sistem',
        self::OWNER => 'Pemilik/Manager - Kelola operasional dan verifikasi pembayaran',
        self::BENDAHARA => 'Bendahara/Staff Keuangan - Kelola keuangan dan buat konten',
        self::PELANGGAN => 'Pelanggan/Wisatawan - Pelanggan yang melakukan reservasi',
    ];

    /**
     * Get all role values
     */
    public static function getValues(): array
    {
        return [
            self::ADMIN,
            self::OWNER,
            self::BENDAHARA,
            self::PELANGGAN,
        ];
    }

    /**
     * Get label untuk role
     */
    public static function getLabel(?string $role): string
    {
        return self::LABELS[$role] ?? 'Unknown';
    }

    /**
     * Get icon untuk role
     */
    public static function getIcon(?string $role): string
    {
        return self::ICONS[$role] ?? '❓';
    }

    /**
     * Get description untuk role
     */
    public static function getDescription(?string $role): string
    {
        return self::DESCRIPTIONS[$role] ?? 'No description available';
    }

    /**
     * Check if role is staff (admin, owner, atau bendahara)
     */
    public static function isStaff(?string $role): bool
    {
        return in_array($role, [self::ADMIN, self::OWNER, self::BENDAHARA]);
    }

    /**
     * Check if role is admin or owner (punya akses management resource)
     */
    public static function canManageResources(?string $role): bool
    {
        return in_array($role, [self::ADMIN, self::OWNER]);
    }

    /**
     * Check if role is bendahara atau admin/owner (punya akses finance)
     */
    public static function canManagePayments(?string $role): bool
    {
        return in_array($role, [self::ADMIN, self::OWNER, self::BENDAHARA]);
    }

    /**
     * Check if role bisa create berita (admin and owner only, NOT bendahara)
     * Bendahara only manages payments/keuangan
     */
    public static function canCreateBerita(?string $role): bool
    {
        return in_array($role, [self::ADMIN, self::OWNER]);
    }

    /**
     * Check if is pelanggan (customer)
     */
    public static function isPelanggan(?string $role): bool
    {
        return $role === self::PELANGGAN;
    }
}
