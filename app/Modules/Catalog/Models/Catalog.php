<?php

namespace App\Modules\Catalog\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    protected  $table = 'katalog';
    protected  $primaryKey = 'katalog_id';

    protected  $fillable = ['katalog_judul', 'katalog_deskripsi', 'katalog_gambar', 'katalog_slug', 'katalog_status', 'katalog_urutan'];

    protected  $casts = [
        'katalog_status' => 'integer',
        'katalog_urutan' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($catalog) {
            if (empty($catalog->katalog_slug)) {
                $catalog->katalog_slug = Str::slug($catalog->katalog_judul);
                $catalog->katalog_urutan = 1;
                while (static::where('katalog_slug', $catalog->katalog_slug)->exists()) {
                    $catalog->katalog_slug = $catalog->katalog_slug . '-' . $catalog->katalog_urutan;
                    $catalog->katalog_urutan++;
                }
            }
        });

        static::updating(function ($catalog) {
            if ($catalog->isDirty('katalog_judul') && !$catalog->isDirty('katalog_slug')) {
                $catalog->katalog_slug = Str::slug($catalog->katalog_judul);
            }
        });
    }

    public function getRouteKeyName() { return 'katalog_slug'; }

    public function getStatusLabelAttribute()
    {
        return $this->katalog_status === 1 ? 'Aktif' : 'Tidak Aktif';
    }
}
