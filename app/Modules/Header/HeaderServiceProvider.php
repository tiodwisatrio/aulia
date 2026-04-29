<?php

namespace App\Modules\Header;

use Illuminate\Support\ServiceProvider;

class HeaderServiceProvider extends ServiceProvider
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

        $this->loadViewsFrom(__DIR__ . '/Views', 'header');
    }
}