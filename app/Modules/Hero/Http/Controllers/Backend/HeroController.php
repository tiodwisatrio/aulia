<?php
// app/Modules/Portfolio/Http/Controllers/Backend/PortfolioController.php

namespace App\Modules\Hero\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Modules\Hero\Models\Hero;
use App\Modules\Portfolio\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    public function index(Request $request)
    {
        $query = Hero::latest();

        if ($request->filled('search')) {
            $query->where('hero_title', 'like', '%' . $request->search . '%');
        }

        $heroes = $query->paginate(10);

        return view('hero::backend.index', compact('heroes'));
    }

    public function create()
    {
        return view('hero::backend.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hero_title'     => 'required|max:255',
            'hero_keterangan' => 'nullable',
            'hero_image'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'hero_status'    => 'required|in:0,1',
        ]);

        $data = $request->only([
            'hero_title', 'hero_keterangan',
            'hero_image',  'hero_status',
        ]);

        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = $request->file('hero_image')
                ->store('uploads/hero', 'public');
        }

        Hero::create($data);

        return redirect()->route('heroes.index')
            ->with('success', 'Hero berhasil ditambahkan.');
    }

    public function show(Hero $hero)
    {
        return view('hero::backend.show', compact('hero'));
    }

    public function edit(Hero $hero)
    {
        return view('hero::backend.edit', compact('hero'));
    }

    public function update(Request $request, Hero $hero)
    {
        $request->validate([
            'hero_title'     => 'required|max:255',
            'hero_keterangan' => 'nullable',
            'hero_image'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'hero_status'    => 'required|in:0,1',
        ]);

        $data = $request->only([
            'hero_title', 'hero_keterangan',
            'hero_image',  'hero_status',
        ]);

        if ($request->hasFile('hero_image')) {
            if ($hero->hero_image) {
                Storage::disk('public')->delete($hero->hero_image);
            }
            $data['hero_image'] = $request->file('hero_image')
                ->store('uploads/hero', 'public');
        }

        $hero->update($data);

        return redirect()->route('heroes.index')
            ->with('success', 'Hero berhasil diperbarui.');
    }

    public function destroy(Hero $hero)
    {
        if ($hero->hero_image) {
            Storage::disk('public')->delete($hero->hero_image);
        }

        $hero->delete();

        return redirect()->route('heroes.index')
            ->with('success', 'Hero berhasil dihapus.');
    }
}