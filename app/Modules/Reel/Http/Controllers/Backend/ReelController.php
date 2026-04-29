<?php

namespace App\Modules\Reel\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Modules\Reel\Models\Reel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReelController extends Controller
{
    public function index(Request $request)
    {
        $query = Reel::orderBy('created_at', 'desc');

        if ($request->search) {
            $query->where('reel_judul', 'like', '%' . $request->search . '%')
                  ->orWhere('reel_url', 'like', '%' . $request->search . '%');
        }

        $reels = $query->paginate(12);
        return view('reel::backend.index', compact('reels'));
    }

    public function create()
    {
        return view('reel::backend.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reel_url'       => 'required|url',
            'reel_judul'     => 'nullable|string|max:255',
            'reel_thumbnail' => 'nullable|image|max:2048',
            'reel_status'    => 'required|in:0,1',
        ]);

        $thumbnail = $request->file('reel_thumbnail')
            ? $request->file('reel_thumbnail')->store('reels', 'public')
            : null;

        Reel::create([
            'reel_url'       => $request->reel_url,
            'reel_judul'     => $request->reel_judul,
            'reel_thumbnail' => $thumbnail,
            'reel_status'    => $request->reel_status,
        ]);

        return redirect()->route('reels.index')->with('success', 'Reel berhasil ditambahkan.');
    }

    public function edit(Reel $reel)
    {
        return view('reel::backend.edit', compact('reel'));
    }

    public function update(Request $request, Reel $reel)
    {
        $request->validate([
            'reel_url'       => 'required|url',
            'reel_judul'     => 'nullable|string|max:255',
            'reel_thumbnail' => 'nullable|image|max:2048',
            'reel_status'    => 'required|in:0,1',
        ]);

        $data = [
            'reel_url'    => $request->reel_url,
            'reel_judul'  => $request->reel_judul,
            'reel_status' => $request->reel_status,
        ];

        if ($request->file('reel_thumbnail')) {
            if ($reel->reel_thumbnail) {
                Storage::disk('public')->delete($reel->reel_thumbnail);
            }
            $data['reel_thumbnail'] = $request->file('reel_thumbnail')->store('reels', 'public');
        }

        $reel->update($data);

        return redirect()->route('reels.index')->with('success', 'Reel berhasil diperbarui.');
    }

    public function destroy(Reel $reel)
    {
        if ($reel->reel_thumbnail) {
            Storage::disk('public')->delete($reel->reel_thumbnail);
        }
        $reel->delete();
        return redirect()->route('reels.index')->with('success', 'Reel berhasil dihapus.');
    }
}
