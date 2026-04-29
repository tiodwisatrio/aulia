<?php

namespace App\Modules\Product\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Modules\User\Models\User;
use App\Modules\Category\Models\Category;

class Product extends Model
{
    use HasFactory;

    protected  $table = 'produk';
    protected  $primaryKey = 'produk_id';

    protected  $fillable = [
        'produk_nama', 'produk_slug', 'produk_deskripsi',
        'produk_harga', 'produk_harga_diskon', 'produk_sku',
        'produk_stok', 'produk_stok_minimum', 'produk_status',
        'produk_gambar_utama', 'produk_galeri', 'produk_spesifikasi',
        'produk_berat', 'produk_dimensi', 'produk_ukuran', 'produk_origin',
        'produk_ketinggian', 'produk_profile_roasting', 'produk_varietas',
        'produk_process', 'produk_roast_date', 'produk_unggulan',
        'produk_pantau_stok', 'produk_meta_deskripsi', 'produk_meta_kata_kunci',
        'produk_kategori_id', 'produk_pengguna_id',
    ];

    protected  $casts = [
        'produk_galeri' => 'array',
        'produk_spesifikasi' => 'array',
        'produk_harga' => 'decimal:2',
        'produk_harga_diskon' => 'decimal:2',
        'produk_berat' => 'decimal:2',
        'produk_unggulan' => 'boolean',
        'produk_pantau_stok' => 'boolean',
        'produk_roast_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'produk_kategori_id', 'kategori_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'produk_pengguna_id', 'id');
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->produk_harga, 0, ',', '.');
    }

    public function getFormattedSalePriceAttribute()
    {
        return $this->produk_harga_diskon ? 'Rp ' . number_format($this->produk_harga_diskon, 0, ',', '.') : null;
    }

    public function getIsOnSaleAttribute()
    {
        return $this->produk_harga_diskon && $this->produk_harga_diskon < $this->produk_harga;
    }

    public function getIsOutOfStockAttribute()
    {
        return $this->produk_pantau_stok && $this->produk_stok <= 0;
    }

    public function getIsLowStockAttribute()
    {
        return $this->produk_pantau_stok && $this->produk_stok <= $this->produk_stok_minimum;
    }

    public function scopeActive()
    {
        return $this->where('produk_status', 'aktif');
    }

    public function scopeFeatured()
    {
        return $this->where('produk_unggulan', true);
    }

    public function scopeInStock()
    {
        return $this->where(function() {
            $this->where('produk_pantau_stok', false)->orWhere('produk_stok', '>', 0);
        });
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->produk_slug)) {
                $product->produk_slug = Str::slug($product->produk_nama);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('produk_nama') && !$product->isDirty('produk_slug')) {
                $product->produk_slug = Str::slug($product->produk_nama);
            }
        });
    }

    public function getRouteKeyName() { return 'produk_slug'; }
}
