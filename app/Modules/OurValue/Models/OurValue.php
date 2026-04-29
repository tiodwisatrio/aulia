<?php

namespace App\Modules\OurValue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurValue extends Model
{
    protected  $table = 'nilai_kami';
    protected  $primaryKey = 'nilai_kami_id';

    protected  $fillable = ['nilai_kami_nama', 'nilai_kami_deskripsi', 'nilai_kami_gambar', 'nilai_kami_status', 'nilai_kami_urutan'];
}
