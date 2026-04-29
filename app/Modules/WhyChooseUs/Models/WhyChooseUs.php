<?php

namespace App\Modules\WhyChooseUs\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhyChooseUs extends Model
{
    use HasFactory;

    protected  $table = 'mengapa_kami';
    protected  $primaryKey = 'mengapa_kami_id';

    protected  $fillable = ['mengapa_kami_judul', 'mengapa_kami_deskripsi', 'mengapa_kami_gambar', 'mengapa_kami_status'];
}
