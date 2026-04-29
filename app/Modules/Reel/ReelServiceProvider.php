<?php

namespace App\Modules\Reel;

use Illuminate\Support\ServiceProvider;

class ReelServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $routesPath = __DIR__ . '/routes.php';
        if (file_exists($routesPath)) {
            $this->app['router']->group(['middleware' => ['web']], function () use ($routesPath) {
                require $routesPath;
            });
        }

        $this->loadViewsFrom(__DIR__ . '/Views', 'reel');
    }
}
