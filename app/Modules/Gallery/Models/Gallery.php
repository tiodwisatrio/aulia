<?php
namespace App\Modules\Gallery\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table      = 'gallery';
    protected $primaryKey = 'gallery_id';

    protected $fillable = [
        'gallery_name',
        'gallery_image',
        'gallery_order',
        'gallery_status',
    ];

    protected $casts = [
        'gallery_status' => 'integer',
        'gallery_order' => 'integer',
    ];
}