<?php

namespace App\Modules\Setting\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Modules\Setting\Models\Setting;
use App\Modules\Setting\Http\Requests\UpdateSettingRequest;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::getSetting();
        return view('setting::backend.index', compact('setting'));
    }

    public function update(UpdateSettingRequest $request)
    {
        $setting = Setting::getSetting();
        $data = $request->validated();

        // Handle file uploads — jangan overwrite jika tidak ada upload baru
        foreach (['site_logo', 'site_logo_dark', 'site_icon'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('settings', 'public');
            } else {
                unset($data[$field]);
            }
        }

        $setting->update($data);

        return redirect()->route('settings.index')
            ->with('success', 'Pengaturan sistem berhasil disimpan!');
    }
}
