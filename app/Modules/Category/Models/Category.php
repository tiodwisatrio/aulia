<?php

namespace App\Modules\Category\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Modules\Post\Models\Post;
use App\Modules\Product\Models\Product;
use App\Modules\Team\Models\Team;
use App\Modules\Menu\Models\Menu;


class Category extends Model
{
    use HasFactory;

    protected  $table = 'kategori';
    protected  $primaryKey = 'kategori_id';

    protected  $fillable = [
        'kategori_nama',
        'kategori_tipe',
        'kategori_slug',
        'kategori_deskripsi',
        'kategori_warna',
        'kategori_ikon',
        'kategori_aktif',
        'kategori_urutan',
    ];

    protected  $casts = [
        'kategori_aktif' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->kategori_slug = autoGenerateSlug($category->kategori_slug, $category->kategori_nama);
        });

        static::updating(function ($category) {
            if ($category->isDirty('kategori_nama')) {
                $category->kategori_slug = generateSlug($category->kategori_nama);
            }
        });
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'posts_kategori_id', 'kategori_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'produk_kategori_id', 'kategori_id');
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class, 'tim_kategori_id', 'kategori_id');
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class, 'menu_kategori_id', 'kategori_id');
    }


    public function scopeActive($query)
    {
        return $query->where('kategori_aktif', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('kategori_urutan')->orderBy('kategori_nama');
    }

    public function scopeForPosts($query)
    {
        return $query->where('kategori_tipe', 'post');
    }

    public function scopeForProducts($query)
    {
        return $query->where('kategori_tipe', 'product');
    }

    public function scopeForMenus($query)
    {
        return $query->where('kategori_tipe', 'menu');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('kategori_tipe', $type);
    }

    public function getRouteKeyName()
    {
        return 'kategori_slug';
    }
}
