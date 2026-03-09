<?php

namespace App\Providers;

use App\Models\WebsiteSetting;
use App\Support\LivewireComponentRegistry;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Shim for older packages (like laravel-ignition) that still expect
        // Livewire\Mechanisms\ComponentRegistry, which was removed in Livewire 4.
        if (!class_exists(\Livewire\Mechanisms\ComponentRegistry::class)) {
            class_alias(LivewireComponentRegistry::class, \Livewire\Mechanisms\ComponentRegistry::class);
        }

        View::composer('layouts.frontend', function ($view) {
            $view->with('websiteSettings', WebsiteSetting::first() ?? new WebsiteSetting);
        });
    }
}
