<?php

namespace App\Modules\Header\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Modules\Header\Models\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeaderController extends Controller
{
    public function index(Request $request)
    {
        $query = Header::latest();

        if ($request->filled('search')) {
            $query->where('header_title', 'like', '%' . $request->search . '%');
        }

        $headers = $query->paginate(10);

        return view('header::backend.index', compact('headers'));
    }

    public function create()
    {
        return view('header::backend.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'header_section'  => 'required|max:100',
            'header_title'    => 'required|max:255',
            'header_subtitle' => 'nullable',
        ]);

        $data = $request->only(['header_section', 'header_title', 'header_subtitle']);

        Header::create($data);

        return redirect()->route('headers.index')
            ->with('success', 'Header berhasil ditambahkan.');
    }

    public function show(Header $header)
    {
        return view('header::backend.show', compact('header'));
    }

    public function edit(Header $header)
    {
        return view('header::backend.edit', compact('header'));
    }

    public function update(Request $request, Header $header)
    {
        $request->validate([
            'header_section'  => 'required|max:100',
            'header_title'    => 'required|max:255',
            'header_subtitle' => 'nullable',
        ]);

        $data = $request->only(['header_section', 'header_title', 'header_subtitle']);

        $header->update($data);

        return redirect()->route('headers.index')
            ->with('success', 'Header berhasil diperbarui.');
    }

    public function destroy(Header $header)
    {
        $header->delete();

        return redirect()->route('headers.index')
            ->with('success', 'Header berhasil dihapus.');
    }
}