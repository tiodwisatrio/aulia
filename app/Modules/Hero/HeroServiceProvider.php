<?php
// app/Modules/Hero/HeroServiceProvider.php

namespace App\Modules\Hero;

use Illuminate\Support\ServiceProvider;

class HeroServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Load routes
        $routesPath = __DIR__ . '/routes.php';
        if (file_exists($routesPath)) {
            $this->app['router']->group(['middleware' => ['web']], function () use ($routesPath) {
                require $routesPath;
            });
        }

        // Load views dengan namespace 'hero'
        $this->loadViewsFrom(__DIR__ . '/Views', 'hero');
    }
}