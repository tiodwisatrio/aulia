<?php

namespace App\Modules\Testimonial\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected  $table = 'testimoni';
    protected  $primaryKey = 'testimoni_id';

    protected  $fillable = ['testimoni_nama', 'testimoni_isi', 'testimoni_gambar', 'testimoni_status', 'testimoni_urutan'];

    protected  $casts = ['testimoni_status' => 'boolean'];
}
