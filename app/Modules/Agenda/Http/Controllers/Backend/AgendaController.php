<?php
namespace App\Modules\Agenda\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Agenda\Models\Agenda;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Agenda::latest();

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('agenda_judul', 'like', '%' . $request->search . '%')
                  ->orWhere('agenda_deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        $agendas = $query->paginate(10);
        return view('agenda::backend.index', compact('agendas'));
    }

    public function create()
    {
        return view('agenda::backend.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'agenda_judul'           => 'required|string|max:255',
            'agenda_slug'            => 'nullable|string|max:255|unique:agenda,agenda_slug',
            'agenda_deskripsi'       => 'nullable|string',
            'agenda_lokasi'          => 'required|string|max:255',
            'agenda_tanggal_mulai'   => 'required|date',
            'agenda_tanggal_selesai' => 'nullable|date|after_or_equal:agenda_tanggal_mulai',
            'agenda_gambar'          => 'nullable|image|max:2048',
            'agenda_status'          => 'required|in:0,1',
        ]);
        $data['agenda_slug'] = $data['agenda_slug'] ?? Str::slug($data['agenda_judul']);
        if ($request->hasFile('agenda_gambar')) {
            $data['agenda_gambar'] = $request->file('agenda_gambar')->store('agenda', 'public');
        }
        Agenda::create($data);
        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit(Agenda $agenda)
    {
        return view('agenda::backend.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $data = $request->validate([
            'agenda_judul'           => 'required|string|max:255',
            'agenda_slug'            => 'nullable|string|max:255|unique:agenda,agenda_slug,' . $agenda->agenda_id . ',agenda_id',
            'agenda_deskripsi'       => 'nullable|string',
            'agenda_lokasi'          => 'required|string|max:255',
            'agenda_tanggal_mulai'   => 'required|date',
            'agenda_tanggal_selesai' => 'nullable|date|after_or_equal:agenda_tanggal_mulai',
            'agenda_gambar'          => 'nullable|image|max:2048',
            'agenda_status'          => 'required|in:0,1',
        ]);
        $data['agenda_slug'] = $data['agenda_slug'] ?? Str::slug($data['agenda_judul']);
        if ($request->hasFile('agenda_gambar')) {
            if ($agenda->agenda_gambar) {
                Storage::disk('public')->delete($agenda->agenda_gambar);
            }
            $data['agenda_gambar'] = $request->file('agenda_gambar')->store('agenda', 'public');
        }
        $agenda->update($data);
        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda)
    {
        if ($agenda->agenda_gambar) {
            Storage::disk('public')->delete($agenda->agenda_gambar);
        }
        $agenda->delete();
        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil dihapus.');
    }
}
