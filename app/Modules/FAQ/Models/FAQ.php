<?php

namespace App\Modules\FAQ\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class FAQ extends Model
{
    protected  $table = 'faq';
    protected  $primaryKey = 'faq_id';

    protected  $fillable = ['faq_pertanyaan', 'faq_jawaban', 'faq_slug', 'faq_status', 'faq_urutan'];

    protected  $casts = [
        'faq_status' => 'integer',
        'faq_urutan' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($faq) {
            if (empty($faq->faq_slug)) {
                $faq->faq_slug = Str::slug($faq->faq_pertanyaan);
                $faq->faq_urutan = 1;
                while (static::where('faq_slug', $faq->faq_slug)->exists()) {
                    $faq->faq_slug = $faq->faq_slug . '-' . $faq->faq_urutan;
                    $faq->faq_urutan++;
                }
            }
        });

        static::updating(function ($faq) {
            if ($faq->isDirty('faq_pertanyaan') && !$faq->isDirty('faq_slug')) {
                $faq->faq_slug = Str::slug($faq->faq_pertanyaan);
            }
        });
    }

    public function getRouteKeyName() { return 'faq_slug'; }

    public function getStatusLabelAttribute()
    {
        return $this->faq_status === 1 ? 'Aktif' : 'Tidak Aktif';
    }
}
