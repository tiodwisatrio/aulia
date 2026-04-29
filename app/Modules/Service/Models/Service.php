<?php

namespace App\Modules\Service\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected  $table = 'layanan';
    protected  $primaryKey = 'layanan_id';

    protected  $fillable = [
        'layanan_nama', 'layanan_deskripsi', 'layanan_gambar', 'layanan_status', 'layanan_urutan',
    ];

    protected  $casts = [
        'layanan_status' => 'integer',
        'layanan_urutan' => 'integer',
    ];

    public function getStatusLabelAttribute()
    {
        return $this->layanan_status === 1 ? 'Aktif' : 'Tidak Aktif';
    }
}
