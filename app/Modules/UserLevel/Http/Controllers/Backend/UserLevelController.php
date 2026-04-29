<?php

namespace App\Modules\UserLevel\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Modules\UserLevel\Models\ModulePermission;
use App\Modules\Navigation\Models\Navigation;
use Illuminate\Http\Request;

class UserLevelController extends Controller
{
    /**
     * Kumpulkan semua modul dari tabel navigations (aktif, punya route, bukan system routes).
     */
    private function getRegisteredModules(): \Illuminate\Support\Collection
    {
        $excludedRoutes = ['#', '', 'dashboard'];
        $excludedPrefixes = ['navigations', 'user-levels', 'users', 'module-generator', 'profile', 'settings'];

        $allNavs = Navigation::where('menu_status', 1)->orderBy('menu_urutan')->get();

        return $allNavs
            ->filter(function ($nav) use ($excludedRoutes, $excludedPrefixes) {
                $route = $nav->menu_route ?? '';
                if (in_array($route, $excludedRoutes)) return false;
                $prefix = explode('.', $route)[0];
                if (in_array($prefix, $excludedPrefixes)) return false;
                return true;
            })
            ->map(function ($nav) {
                $route = $nav->menu_route ?? '';
                // Normalize to .index form for module_name key
                $parts = explode('.', $route);
                $moduleName = $parts[0] . '.index';
                return [
                    'name'  => $moduleName,
                    'label' => $nav->menu_label,
                    'route' => $route,
                ];
            })
            ->unique('name')
            ->values();
    }

    public function index()
    {
        $modules     = $this->getRegisteredModules();
        $permissions = ModulePermission::all()->keyBy('module_name');

        return view('user-level::backend.index', compact('modules', 'permissions'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'permissions'          => 'nullable|array',
            'permissions.*.roles'  => 'nullable|array',
            'permissions.*.roles.*'=> 'in:admin,super_admin,developer',
        ]);

        $modules     = $this->getRegisteredModules();
        $incoming    = $request->input('permissions', []);

        foreach ($modules as $mod) {
            $name  = $mod['name'];
            $roles = $incoming[$name]['roles'] ?? [];

            // Minimal selalu ada developer (developer selalu punya akses)
            if (!in_array('developer', $roles)) {
                $roles[] = 'developer';
            }

            ModulePermission::updateOrCreate(
                ['module_name' => $name],
                [
                    'module_label'  => $mod['label'],
                    'allowed_roles' => $roles,
                ]
            );
        }

        return redirect()->route('user-levels.index')
            ->with('success', 'Pengaturan akses modul berhasil disimpan!');
    }
}
