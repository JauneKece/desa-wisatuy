<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Run every 15 minutes to pick up expired reservations quickly
        $schedule->command('reservasi:cancel-expired')->everyFifteenMinutes();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
