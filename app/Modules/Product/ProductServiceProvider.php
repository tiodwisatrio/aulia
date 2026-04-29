<?php

namespace App\Modules\Product;

use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadRoutes();
        $this->loadViews();
        $this->loadPermissions();
    }

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

    protected function loadViews(): void
    {
        $viewPath = __DIR__ . '/Views';
        $this->loadViewsFrom($viewPath, 'product');
    }

    protected function loadPermissions(): void
    {
        $permissionsPath = __DIR__ . '/permissions.php';
        if (file_exists($permissionsPath)) {
            require $permissionsPath;
        }
    }
}
