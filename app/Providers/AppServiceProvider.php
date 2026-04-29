<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Modules\User\Models\User;
use App\Modules\UserLevel\Models\ModulePermission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind User model to the container for authentication
        $this->app->bind('user-model', User::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Admin access - for Admin, Super Admin, and Developer
        // Also checks module_permissions table if a module name is passed as argument
        Gate::define('admin-access', function ($user, ?string $moduleName = null) {
            if (!$user->isAdmin()) {
                return false;
            }
            // Developer always passes
            if ($user->isDeveloper()) {
                return true;
            }
            // If a specific module is requested, check DB permissions
            if ($moduleName) {
                return ModulePermission::roleCanAccess($moduleName, $user->role);
            }
            return true;
        });

        // Super Admin access - for Super Admin and Developer only
        Gate::define('super-admin-access', function ($user) {
            return $user->isSuperAdmin();
        });

        // Developer access - only for Developer role
        Gate::define('developer-access', function ($user) {
            return $user->isDeveloper();
        });

        // User management access - Super Admin and Developer
        Gate::define('manage-users', function ($user) {
            return $user->canManageUsers();
        });

        // Check if user can modify another user
        Gate::define('modify-user', function ($user, $targetUser) {
            return $user->canModifyUser($targetUser);
        });

        // Automatically apply module-access check to all dashboard routes
        $this->app['router']->pushMiddlewareToGroup('web', \App\Http\Middleware\CheckModuleAccess::class);
    }
}
