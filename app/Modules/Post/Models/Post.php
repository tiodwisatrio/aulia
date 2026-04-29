<?php

namespace App\Modules\Post\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use App\Modules\User\Models\User;
use App\Modules\Category\Models\Category;


class Post extends Model
{
    use HasFactory;

    protected  $table = 'posts';
    protected  $primaryKey = 'posts_id';

    protected  $fillable = [
        'posts_judul',
        'posts_slug',
        'posts_konten',
        'posts_deskripsi',
        'posts_kategori_id',
        'posts_gambar_utama',
        'posts_dokumen',
        'posts_harga',
        'posts_status',
        'posts_tanggal_publish',
        'posts_tanggal_acara',
        'posts_batas_waktu',
        'posts_unggulan',
        'posts_pengguna_id',
    ];

    protected  $casts = [
        'posts_unggulan' => 'boolean',
        'posts_dokumen' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->posts_slug)) {
                $base = static::generateSlug($post->posts_judul);
                $slug = $base;
                $counter = 1;
                while (static::where('posts_slug', $slug)->exists()) {
                    $slug = $base . '-' . $counter++;
                }
                $post->posts_slug = $slug;
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('posts_judul') && !$post->isDirty('posts_slug')) {
                $post->posts_slug = static::generateSlug($post->posts_judul);
            }
        });
    }

    public static function generateSlug($title)
    {
        return Str::slug($title, '-', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'posts_pengguna_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'posts_kategori_id', 'kategori_id');
    }

    public function posts_kategori(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'posts_kategori_id', 'kategori_id');
    }

    public function scopeActive()
    {
        return $this->where('posts_status', 'aktif');
    }

    public function scopeFeatured()
    {
        return $this->where('posts_unggulan', true);
    }

    public function scopeByCategory($categoryId)
    {
        return $this->where('posts_kategori_id', $categoryId);
    }

    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->posts_konten));
        return ceil($wordCount / 200);
    }

    public function getExcerptAttribute()
    {
        return $this->posts_deskripsi ?: Str::limit(strip_tags($this->posts_konten), 150);
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d M Y');
    }

    public function getRouteKeyName()
    {
        return 'posts_slug';
    }
}
