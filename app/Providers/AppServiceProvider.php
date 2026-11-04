<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Pagination bawaan Laravel pakai ikon SVG dari Tailwind CSS, yang
        // ukurannya jadi raksasa kalau Tailwind tidak ter-load (seperti di
        // project ini). Jadi dipakai view kustom sendiri yang cocok dengan
        // desain web (lihat resources/views/vendor/pagination/custom.blade.php).
        Paginator::defaultView("vendor.pagination.custom");
        Paginator::defaultSimpleView("vendor.pagination.custom");
    }
}