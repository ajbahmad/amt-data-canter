<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;

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
        // Register UUID macro untuk Blueprint
        Blueprint::macro('uuid', function ($column = 'id') {
            return $this->char($column, 36);
        });

        // Set default untuk Model menggunakan UUID
        // Semua model yang inherit dari BaseModel akan otomatis pakai UUID
    }
}
