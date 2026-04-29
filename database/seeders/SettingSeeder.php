<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Setting\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::firstOrCreate([], [
            'site_name'        => 'Nama Site',
            'site_name_alt'    => '',
            'site_address'     => '',
            'site_phone'       => '',
            'site_fax'         => '',
            'site_mobile'      => '',
            'site_email'       => '',
            'site_whatsapp'    => '',
            'site_instagram'   => '',
            'site_youtube'     => '',
            'site_tiktok'      => '',
            'site_twitter'     => '',
            'site_map'         => '',
            'site_description' => '',
            'site_logo'        => null,
            'site_logo_dark'   => null,
            'site_icon'        => null,
        ]);

        $this->command->info('Site settings seeded.');
    }
}
