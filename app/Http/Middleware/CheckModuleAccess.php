<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\UserLevel\Models\ModulePermission;

class CheckModuleAccess
{
    /**
     * Cek apakah user boleh akses modul berdasarkan route name.
     * Route name format: {module}.{action} — misal: posts.index, posts.create, dst.
     *
     * Usage di route: ->middleware('module-access')
     */
    /**
     * Route prefix yang dieksklusi dari pengecekan modul
     * (halaman yang selalu boleh diakses oleh semua role login).
     */
    private const EXCLUDED_PREFIXES = [
        'dashboard',       // halaman utama dashboard
        'navigations',
        'user-levels',
        'users',
        'profile',
        'settings',
        'module-generator',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // Hanya proses request ke /dashboard/*
        if (!str_starts_with($request->path(), 'dashboard')) {
            return $next($request);
        }

        $user = auth()->user();

        // Belum login: biarkan auth middleware yang tangani
        if (!$user) {
            return $next($request);
        }

        // Developer selalu lolos
        if ($user->isDeveloper()) {
            return $next($request);
        }

        // Ambil prefix modul dari route name: "posts.index" → "posts"
        $routeName    = $request->route()?->getName() ?? '';
        $modulePrefix = str_contains($routeName, '.') ? explode('.', $routeName)[0] : null;

        // Skip modul yang dieksklusi
        if (!$modulePrefix || in_array($modulePrefix, self::EXCLUDED_PREFIXES)) {
            return $next($request);
        }

        $moduleName = $modulePrefix . '.index';

        if (!ModulePermission::roleCanAccess($moduleName, $user->role)) {
            abort(403, 'Role Anda tidak memiliki akses ke modul ini.');
        }

        return $next($request);
    }
}
