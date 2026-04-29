<?php

namespace App\Modules\Header\Models;

use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    protected $table      = 'header';
    protected $primaryKey = 'header_id';

    protected $fillable = [
        'header_section',
        'header_title',
        'header_subtitle',
    ];

  
   
}