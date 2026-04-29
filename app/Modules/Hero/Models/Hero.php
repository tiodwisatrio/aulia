<?php

namespace App\Modules\Hero\Models;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $table      = 'hero';
    protected $primaryKey = 'hero_id';

    protected $fillable = [
        'hero_title',
        'hero_keterangan',
        'hero_image',
        'hero_status',
    ];

    protected $casts = [
        'hero_status' => 'integer',
    ];

   
}