<?php

namespace App\Modules\Core;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadViews();
        $this->loadRoutes();
    }

    /**
     * Load views from this module
     */
    protected function loadViews(): void
    {
        $viewPath = __DIR__ . '/Views';
        $this->loadViewsFrom($viewPath, 'core');
    }

    /**
     * Load routes from this module
     */
    protected function loadRoutes(): void
    {
        $routesPath = __DIR__ . '/routes.php';
        if (file_exists($routesPath)) {
            $this->app['router']->group([
                'middleware' => ['web'],
            ], function () use ($routesPath) {
                require $routesPath;
            });
        }
    }
}
