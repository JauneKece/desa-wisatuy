<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Payment;
use App\Models\Reservasi;
use App\Policies\PaymentPolicy;
use App\Policies\ReservasiPolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register authorization policies
        Gate::policy(Payment::class, PaymentPolicy::class);
        Gate::policy(Reservasi::class, ReservasiPolicy::class);
    }
}
