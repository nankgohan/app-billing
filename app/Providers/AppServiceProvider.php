<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use RealRashid\SweetAlert\Facades\Alert;

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
        // lalu di controller atau route:
        Alert::success('Berhasil', 'Kamu berhasil login');
    }
}
