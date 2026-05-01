<?php

namespace App\Modules\Menu\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Modules\User\Models\User;
use App\Modules\Category\Models\Category;

class Menu extends Model
{
    use HasFactory;

    protected  $table = 'menus';
    protected  $primaryKey = 'id';

    protected  $fillable = [
        'menu_nama',
        'menu_slug',
        'menu_harga',
        'menu_image',
        'menu_deskripsi',
        'menu_kategori_id',
        'menu_status',
    ];

    protected  $casts = [
        'menu_harga' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'menu_kategori_id', 'kategori_id');
    }

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'produk_pengguna_id', 'id');
    // }

    public function getFormattedPriceAttribute()
    {
        return formatYen($this->menu_harga);
    }

  



  

  
    public function scopeActive($query)
    {
        return $query->where('menu_status', 'aktif');
    }

    public function scopeFeatured()
    {
        return $this->where('produk_unggulan', true);
    }

 

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($menu) {
            if (empty($menu->menu_slug)) {
                $menu->menu_slug = Str::slug($menu->menu_nama);
            }
        });

        static::updating(function ($menu) {
            if ($menu->isDirty('menu_nama') && !$menu->isDirty('menu_slug')) {
                $menu->menu_slug = Str::slug($menu->menu_nama);
            }
        });
    }

    public function getRouteKeyName() { return 'menu_slug'; }
}
