<?php

namespace App\Modules\Menu\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Modules\Menu\Models\Menu;
use App\Modules\Category\Models\Category;
use App\Modules\Menu\Http\Requests\StoreMenuRequest;
use App\Modules\Menu\Http\Requests\UpdateMenuRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::with(['category']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('menu_nama', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('menu_kategori_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('menu_status', $request->status);
        }


     

        $menus = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::forMenus()->active()->ordered()->get();

        return view('menu::backend.index', compact('menus', 'categories'));
    }

    public function create()
    {
        $categories = Category::forMenus()->active()->ordered()->get();

        return view('menu::backend.create', compact('categories'));
    }

    public function store(StoreMenuRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('menu_image')) {
            $validated['menu_image'] = $request->file('menu_image')
                ->store('menus/images', 'public');
        }

   

   
        if (empty($validated['menu_slug'])) {
            $validated['menu_slug'] = Str::slug($validated['menu_nama']);
        }


        Menu::create($validated);

        return redirect()->route('menus.index')
            ->with('success', 'Menu berhasil dibuat!');
    }

    public function show(Menu $menu)
    {
        $menu->load(['category']);


        return view('menu::backend.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        $categories = Category::forMenus()->active()->ordered()->get();

        return view('menu::backend.edit', compact('menu', 'categories'));
    }

    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $validated = $request->validated();

        if ($request->has('remove_current_image') && $menu->menu_image) {
            Storage::disk('public')->delete($menu->menu_image);
            $validated['menu_image'] = null;
        }

        if ($request->hasFile('menu_image')) {
            if ($menu->menu_image && !$request->has('remove_current_image')) {
                Storage::disk('public')->delete($menu->menu_image);
            }
            $validated['menu_image'] = $request->file('menu_image')
                ->store('menus/images', 'public');
        }

    


   

        $menu->update($validated);

        return redirect()->route('menus.index')
            ->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->menu_image) {
            Storage::disk('public')->delete($menu->menu_image);
        }


        $menu->delete();

        return redirect()->route('menus.index')
            ->with('success', 'Menu berhasil dihapus!');
    }
}
