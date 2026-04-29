<?php

namespace App\Modules\Catalog\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\Catalog\Models\Catalog;

class CatalogController extends Controller
{
    public function index()
    {
        $catalogs = Catalog::where('status', 1)
            ->orderBy('order')
            ->paginate(12);

        return view('catalog::frontend.index', compact('catalogs'));
    }

    public function show(Catalog $catalog)
    {
        if ($catalog->status !== 1) {
            abort(404);
        }

        return view('catalog::frontend.show', compact('catalog'));
    }
}
