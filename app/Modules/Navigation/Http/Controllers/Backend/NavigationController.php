<?php

namespace App\Modules\Navigation\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Modules\Navigation\Models\Navigation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class NavigationController extends Controller
{
    public function index()
    {
        // Hanya parent (top-level) dengan children eager loaded
        $navigations = Navigation::whereNull('menu_parent_id')
            ->with(['children' => fn($q) => $q->orderBy('menu_urutan')])
            ->orderBy('menu_urutan')
            ->get();

        $existingRoutes = Navigation::whereNull('menu_parent_id')->pluck('menu_route')->toArray();
        $excludedRoutes = ['module-generator.index', 'categories.index'];

        $availableModules = collect(Route::getRoutes())
            ->filter(fn($r) => str_ends_with($r->getName() ?? '', '.index')
                && str_starts_with($r->uri(), 'dashboard/')
                && !in_array($r->getName(), $excludedRoutes)
                && !in_array($r->getName(), $existingRoutes))
            ->map(fn($r) => [
                'name'  => $r->getName(),
                'label' => ucwords(str_replace(['.index', '-', '_'], ['', ' ', ' '], $r->getName())),
            ])
            ->values();

        return view('navigation::backend.index', compact('navigations', 'availableModules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_label'     => 'required|string|max:255',
            'menu_route'     => 'nullable|string|max:255',
            'menu_ikon'      => 'nullable|string|max:255',
            'menu_status'    => 'required|boolean',
            'menu_parent_id' => 'nullable|integer|exists:menu,menu_id',
            'menu_roles'     => 'nullable|array',
            'menu_roles.*'   => 'in:admin,super_admin,developer',
        ]);

        $maxUrutan = Navigation::where('menu_parent_id', $request->menu_parent_id ?? null)->max('menu_urutan') ?? -1;

        Navigation::create([
            'menu_parent_id' => $request->menu_parent_id ?: null,
            'menu_label'     => $request->menu_label,
            'menu_route'     => $request->menu_route,
            'menu_ikon'      => $request->menu_ikon,
            'menu_status'    => $request->menu_status,
            'menu_urutan'    => $maxUrutan + 1,
            'menu_roles'     => $request->menu_roles ?? ['admin', 'super_admin', 'developer'],
        ]);

        return redirect()->route('navigations.index')->with('success', 'Menu berhasil ditambahkan');
    }

    public function update(Request $request, Navigation $navigation)
    {
        $request->validate([
            'menu_label'   => 'required|string|max:255',
            'menu_route'   => 'nullable|string|max:255',
            'menu_ikon'    => 'nullable|string|max:255',
            'menu_status'  => 'required|boolean',
            'menu_roles'   => 'nullable|array',
            'menu_roles.*' => 'in:admin,super_admin,developer',
        ]);

        $navigation->update([
            'menu_label'  => $request->menu_label,
            'menu_route'  => $request->menu_route,
            'menu_ikon'   => $request->menu_ikon,
            'menu_status' => $request->menu_status,
            'menu_roles'  => $request->menu_roles ?? ['admin', 'super_admin', 'developer'],
        ]);

        return redirect()->route('navigations.index')->with('success', $navigation->menu_label . ' berhasil diperbarui');
    }

    public function destroy(Navigation $navigation)
    {
        // Hapus children juga
        $navigation->children()->delete();
        $navigation->delete();
        return redirect()->route('navigations.index')->with('success', 'Menu berhasil dihapus');
    }

    public function reorder(Request $request)
    {
        $items = json_decode($request->input('items', '[]'), true);

        foreach ($items as $parentOrder => $item) {
            Navigation::where('menu_id', $item['id'])->update([
                'menu_parent_id' => null,
                'menu_urutan'    => $parentOrder,
            ]);

            if (!empty($item['children'])) {
                foreach ($item['children'] as $childOrder => $childId) {
                    Navigation::where('menu_id', $childId)->update([
                        'menu_parent_id' => $item['id'],
                        'menu_urutan'    => $childOrder,
                    ]);
                }
            }
        }

        return response()->json(['success' => true]);
    }
}
