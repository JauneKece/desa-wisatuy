<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
{
    /**
     * Determine whether the user can view the payment proof.
     * 
     * Admin/Owner: dapat view semua payment
     * Bendahara: dapat view semua payment
     * Pelanggan: hanya view payment milik sendiri
     */
    public function viewProof(User $user, Payment $payment): bool
    {
        // Admin, Owner, Bendahara dapat view semua
        if (in_array($user->role, ['admin', 'owner', 'bendahara'])) {
            return true;
        }

        // Pelanggan hanya view milik sendiri
        if ($user->role === 'pelanggan') {
            // Check if payment belongs to user's reservation
            if ($user->pelanggan && $payment->reservasi->pelanggan_id === $user->pelanggan->id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can verify/approve the payment.
     * Only Admin, Owner, and Bendahara can verify payments.
     */
    public function verify(User $user, Payment $payment): bool
    {
        return in_array($user->role, ['admin', 'owner', 'bendahara']);
    }

    /**
     * Determine whether the user can reject/fail the payment.
     * Only Admin, Owner, and Bendahara can reject payments.
     */
    public function reject(User $user, Payment $payment): bool
    {
        return in_array($user->role, ['admin', 'owner', 'bendahara']);
    }
}
