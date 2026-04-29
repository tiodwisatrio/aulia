<?php

use Illuminate\Support\Facades\Gate;
use App\Modules\User\Models\User;

/**
 * User Module Permissions
 *
 * Define all gates and authorization checks for user management
 */

// Check if user can manage users (view list, create, edit)
Gate::define('manage-users', function (User $user) {
    return $user->isSuperAdmin();
});

// Check if user can modify a specific user
Gate::define('modify-user', function (User $user, User $target) {
    return $user->canModifyUser($target);
});
