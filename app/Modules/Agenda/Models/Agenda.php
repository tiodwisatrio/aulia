<?php

namespace App\Modules\Agenda\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Agenda extends Model
{
    use HasFactory;

    protected  $table = 'agenda';
    protected  $primaryKey = 'agenda_id';

    protected  $fillable = [
        'agenda_judul', 'agenda_slug', 'agenda_deskripsi', 'agenda_lokasi',
        'agenda_tanggal_mulai', 'agenda_tanggal_selesai', 'agenda_gambar', 'agenda_status', 'agenda_urutan',
    ];
}
