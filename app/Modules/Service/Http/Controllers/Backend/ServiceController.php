<?php

namespace App\Modules\Service\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Service\Models\Service;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::latest();

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('layanan_nama', 'like', '%' . $request->search . '%')
                  ->orWhere('layanan_deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        $services = $query->paginate(10);
        return view('service::backend.index', compact('services'));
    }

    public function create()
    {
        return view('service::backend.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'layanan_nama'      => 'required|max:255',
            'layanan_deskripsi' => 'nullable',
            'layanan_gambar'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'layanan_status'    => 'required|in:0,1',
            'layanan_urutan'    => 'nullable|integer',
        ]);

        $data = $request->only(['layanan_nama', 'layanan_deskripsi', 'layanan_status', 'layanan_urutan']);

        if ($request->hasFile('layanan_gambar')) {
            $data['layanan_gambar'] = $request->file('layanan_gambar')->store('uploads/layanan', 'public');
        }

        Service::create($data);

        return redirect()->route('services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function show(Service $service)
    {
        return view('service::backend.show', compact('service'));
    }

    public function edit(Service $service)
    {
        return view('service::backend.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'layanan_nama'      => 'required|max:255',
            'layanan_deskripsi' => 'nullable',
            'layanan_gambar'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'layanan_status'    => 'required|in:0,1',
            'layanan_urutan'    => 'nullable|integer',
        ]);

        $data = $request->only(['layanan_nama', 'layanan_deskripsi', 'layanan_status', 'layanan_urutan']);

        if ($request->hasFile('layanan_gambar')) {
            if ($service->layanan_gambar) {
                Storage::disk('public')->delete($service->layanan_gambar);
            }
            $data['layanan_gambar'] = $request->file('layanan_gambar')->store('uploads/layanan', 'public');
        }

        $service->update($data);

        return redirect()->route('services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        if ($service->layanan_gambar) {
            Storage::disk('public')->delete($service->layanan_gambar);
        }
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
