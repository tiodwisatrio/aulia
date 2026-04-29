<?php

namespace App\Modules\Setting\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'site_settings';

    protected $fillable = [
        'site_name', 'site_name_alt', 'site_address',
        'site_phone', 'site_fax', 'site_mobile', 'site_email', 'site_whatsapp',
        'site_instagram', 'site_youtube', 'site_tiktok', 'site_twitter',
        'site_map', 'site_description',
        'site_logo', 'site_logo_dark', 'site_icon',
    ];

    /**
     * Ambil setting (selalu row pertama, buat jika belum ada).
     */
    public static function getSetting(): self
    {
        return self::firstOrCreate([]);
    }
}
