<?php

namespace App\Modules\Team\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Category\Models\Category;

class Team extends Model
{
    use HasFactory;

    protected  $table = 'tim';
    protected  $primaryKey = 'tim_id';

    protected  $fillable = ['tim_nama', 'tim_kategori_id', 'tim_gambar', 'tim_deskripsi', 'tim_status'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'tim_kategori_id', 'kategori_id');
    }
}
