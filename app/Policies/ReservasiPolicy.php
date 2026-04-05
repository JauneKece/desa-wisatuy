<?php

namespace App\Policies;

use App\Models\Reservasi;
use App\Models\User;

class ReservasiPolicy
{
    /**
     * Determine whether the user can view the reservasi.
     * 
     * Admin/Owner: dapat view semua reservasi
     * Pelanggan: hanya view reservasi milik sendiri
     */
    public function view(User $user, Reservasi $reservasi): bool
    {
        // Admin dan Owner dapat view semua
        if (in_array($user->role, ['admin', 'owner'])) {
            return true;
        }

        // Pelanggan hanya view milik sendiri
        if ($user->role === 'pelanggan') {
            if ($user->pelanggan && $user->pelanggan->id === $reservasi->pelanggan_id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can update the reservasi.
     * 
     * Admin/Owner: dapat update semua
     * Pelanggan: hanya update milik sendiri (jika status pending)
     */
    public function update(User $user, Reservasi $reservasi): bool
    {
        // Admin dan Owner dapat update semua
        if (in_array($user->role, ['admin', 'owner'])) {
            return true;
        }

        // Pelanggan hanya update milik sendiri
        if ($user->role === 'pelanggan') {
            if ($user->pelanggan && $user->pelanggan->id === $reservasi->pelanggan_id) {
                // Optional: check if status is pending for more restrictions
                return $reservasi->status === 'pending';
            }
        }

        return false;
    }

    /**
     * Determine whether the user can delete the reservasi.
     * 
     * Admin/Owner: dapat delete semua
     * Pelanggan: dapat delete milik sendiri
     */
    public function delete(User $user, Reservasi $reservasi): bool
    {
        // Admin dan Owner dapat delete semua
        if (in_array($user->role, ['admin', 'owner'])) {
            return true;
        }

        // Pelanggan hanya delete milik sendiri
        if ($user->role === 'pelanggan') {
            if ($user->pelanggan && $user->pelanggan->id === $reservasi->pelanggan_id) {
                return true;
            }
        }

        return false;
    }
}
