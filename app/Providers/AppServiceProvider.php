<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Явно указываем Tailwind-стили для пагинации.
        // В Laravel 13 это уже дефолт, но явный вызов делает намерение очевидным.
        Paginator::useTailwind();
    }
}
