<?php

use App\Modules\Setting\Models\Setting;

if (! function_exists('setting')) {
    /**
     * Ambil nilai pengaturan dari tabel site_settings.
     * Contoh: setting('nama_site'), setting('email', 'default@example.com')
     */
    function setting(string $key, $default = null)
    {
        static $cached = null;

        if ($cached === null) {
            $cached = Setting::first();
        }

        if (! $cached) return $default;

        return $cached->$key ?? $default;
    }
}
