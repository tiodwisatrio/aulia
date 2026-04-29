<?php

namespace App\Services;

use App\Modules\Setting\Models\Setting;
use Illuminate\Support\Facades\Config;

class MailConfigService
{
    public static function setMailConfig()
    {
        // Mail config is read from .env / config/mail.php
        // Override with site settings if available
        $setting = Setting::getSetting();

        if ($setting->site_email) {
            Config::set('mail.from.address', $setting->site_email);
        }

        if ($setting->site_name) {
            Config::set('mail.from.name', $setting->site_name);
        }
    }
}
