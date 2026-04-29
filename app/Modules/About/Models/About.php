<?php

namespace App\Modules\About\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $table = 'tentang';
    protected $primaryKey = 'tentang_id';

    protected $fillable = [
        'tentang_judul',
        'tentang_konten',
        'tentang_gambar',
        'tentang_status',
        'tentang_jumlah_origin',
        'tentang_jumlah_pelanggan',
        'tentang_jumlah_fresh_roast',
        'tentang_tahun_berdiri',
    ];

    protected $casts = ['tentang_status' => 'boolean'];
}
