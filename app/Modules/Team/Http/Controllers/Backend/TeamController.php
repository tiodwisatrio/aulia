<?php
namespace App\Modules\Team\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Modules\Team\Models\Team;
use App\Modules\Category\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $query = Team::with('category')->latest();

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('tim_nama', 'like', '%' . $request->search . '%')
                  ->orWhereHas('category', function($cat) use ($request) {
                      $cat->where('kategori_nama', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $teams = $query->paginate(10);
        return view('team::backend.index', compact('teams'));
    }

    public function create()
    {
        $categories = Category::where('kategori_tipe', 'team')->where('kategori_aktif', 1)->get();
        return view('team::backend.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tim_nama'        => 'required|string|max:255',
            'tim_kategori_id' => 'required|exists:kategori,kategori_id',
            'tim_gambar'      => 'nullable|image|max:2048',
            'tim_deskripsi'   => 'nullable|string',
            'tim_status'      => 'required|in:0,1',
        ]);

        if ($request->hasFile('tim_gambar')) {
            $validated['tim_gambar'] = $request->file('tim_gambar')->store('tim', 'public');
        }
        Team::create($validated);
        return redirect()->route('teams.index')->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function show(Team $team)
    {
        return view('team::backend.show', compact('team'));
    }

    public function edit(Team $team)
    {
        $categories = Category::where('kategori_tipe', 'team')->where('kategori_aktif', 1)->get();
        return view('team::backend.edit', compact('team', 'categories'));
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'tim_nama'        => 'required|string|max:255',
            'tim_kategori_id' => 'required|exists:kategori,kategori_id',
            'tim_gambar'      => 'nullable|image|max:2048',
            'tim_deskripsi'   => 'nullable|string',
            'tim_status'      => 'required|in:0,1',
        ]);

        if ($request->hasFile('tim_gambar')) {
            if ($team->tim_gambar) {
                Storage::disk('public')->delete($team->tim_gambar);
            }
            $validated['tim_gambar'] = $request->file('tim_gambar')->store('tim', 'public');
        }
        $team->update($validated);
        return redirect()->route('teams.index')->with('success', 'Anggota tim berhasil diperbarui.');
    }

    public function destroy(Team $team)
    {
        if ($team->tim_gambar) {
            Storage::disk('public')->delete($team->tim_gambar);
        }
        $team->delete();
        return redirect()->route('teams.index')->with('success', 'Anggota tim berhasil dihapus.');
    }
}
