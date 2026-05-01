<?php

namespace App\Modules\Menu\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\Menu\Models\Menu;
use App\Modules\Category\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with(['menus' => function ($q) {
                $q->where('menu_status', 'aktif')->orderBy('id');
            }])
            ->where('kategori_tipe', 'menu')
            ->where('kategori_aktif', true)
            ->orderBy('kategori_urutan')
            ->get()
            ->filter(fn($c) => $c->menus->count() > 0)
            ->values();

        $activeCategory = $request->get('kategori');

        return view('menu::frontend.index', compact('categories', 'activeCategory'));
    }
}
