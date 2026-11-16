<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Hanya Admin dan Petugas yang boleh mengelola buku.
        Gate::define('kelola-buku', function ($user) {
            return $user->hasAnyRole(['Admin', 'Petugas']);
        });
    }
}
