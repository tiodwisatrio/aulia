<?php

namespace App\Modules\Navigation\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Navigation extends Model
{
    use HasFactory;

    protected  $table = 'menu';
    protected  $primaryKey = 'menu_id';

    protected  $fillable = ['menu_parent_id', 'menu_label', 'menu_route', 'menu_ikon', 'menu_urutan', 'menu_status', 'menu_roles'];

    protected  $casts = [
        'menu_status' => 'boolean',
        'menu_roles'  => 'array',
    ];

    

    /**
     * Cek apakah role tertentu boleh melihat menu ini.
     */
    public function isVisibleForRole(string $role): bool
    {
        $roles = $this->menu_roles ?? ['admin', 'super_admin', 'developer'];
        return in_array($role, $roles);
    }

    public function children()
    {
        return $this->hasMany(Navigation::class, 'menu_parent_id', 'menu_id')->orderBy('menu_urutan');
    }

    public function parent()
    {
        return $this->belongsTo(Navigation::class, 'menu_parent_id', 'menu_id');
    }
}
