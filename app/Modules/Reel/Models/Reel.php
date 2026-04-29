<?php

namespace App\Modules\Reel\Models;

use Illuminate\Database\Eloquent\Model;

class Reel extends Model
{
    protected $table      = 'reels';
    protected $primaryKey = 'reel_id';

    protected $fillable = [
        'reel_judul',
        'reel_url',
        'reel_thumbnail',
        'reel_status',
    ];

    protected $casts = [
        'reel_status' => 'boolean',
    ];

    /**
     * Ekstrak shortcode dari URL Instagram untuk dijadikan embed.
     * Contoh: https://www.instagram.com/reel/DW8qXjokdJw/... → DW8qXjokdJw
     */
    public function getShortcodeAttribute(): ?string
    {
        if (preg_match('#instagram\.com/(?:p|reel)/([A-Za-z0-9_-]+)#', $this->reel_url, $m)) {
            return $m[1];
        }
        return null;
    }

    public function getEmbedUrlAttribute(): string
    {
        $code = $this->shortcode;
        return "https://www.instagram.com/p/{$code}/embed/";
    }
}
