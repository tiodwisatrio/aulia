<?php

namespace App\Modules\OurClient\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class OurClient extends Model
{
    use HasFactory;

    protected  $table = 'klien';
    protected  $primaryKey = 'klien_id';

    protected  $fillable = ['klien_nama', 'klien_gambar', 'klien_status', 'klien_urutan'];

    protected  $casts = ['klien_status' => 'boolean'];
}
