<?php

namespace App\Modules\Service\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\Service\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('layanan_status', 1)
            ->orderBy('layanan_urutan')
            ->paginate(10);

        return view('service::frontend.index', compact('services'));
    }

    public function show(Service $service)
    {
        if ($service->layanan_status !== 1) {
            abort(404);
        }

        return view('service::frontend.show', compact('service'));
    }
}
