<?php

namespace App\Console\Commands;

use App\Models\Reservasi;
use Illuminate\Console\Command;

class CancelExpiredReservations extends Command
{
    protected $signature = 'reservasi:cancel-expired';
    protected $description = 'Cancel expired pending reservations';

    public function handle()
    {
        $count = Reservasi::where('status', 'pending')
            ->whereNotNull('expired_at')
            ->where('expired_at', '<', now())
            ->update(['status' => 'expired']);

        $this->info("Cancelled {$count} expired reservations.");
        return 0;
    }
}
