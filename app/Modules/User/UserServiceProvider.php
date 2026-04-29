<?php

namespace App\Modules\User;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
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
        $this->loadPermissions();
        $this->loadRoutes();
    }

    /**
     * Load views from this module
     */
    protected function loadViews(): void
    {
        $viewPath = __DIR__ . '/Views';
        $this->loadViewsFrom($viewPath, 'user');
    }

    /**
     * Load permissions/gates from this module
     */
    protected function loadPermissions(): void
    {
        $permissionsPath = __DIR__ . '/permissions.php';
        if (file_exists($permissionsPath)) {
            require $permissionsPath;
        }
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
