<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;

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
        //
        View::composer('layouts.sidebar', function ($view) {
            $view->with('menus', Menu::all());
        });
        // Membuat variabel $user tersedia di semua view
        View::composer('*', function ($view) {
            $view->with('user', auth()->user());
        });
        if (!Storage::disk('database_backup')->exists('/')) {
            Storage::disk('database_backup')->makeDirectory('/');
        }
    }
}
