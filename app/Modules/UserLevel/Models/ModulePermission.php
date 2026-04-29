<?php

namespace App\Modules\UserLevel\Models;

use Illuminate\Database\Eloquent\Model;

class ModulePermission extends Model
{
    protected $table = 'module_permissions';

    protected $fillable = [
        'module_name',
        'module_label',
        'allowed_roles',
    ];

    protected $casts = [
        'allowed_roles' => 'array',
    ];

    /**
     * Cek apakah role tertentu boleh akses modul ini.
     */
    public function isAllowed(string $role): bool
    {
        return in_array($role, $this->allowed_roles ?? []);
    }

    /**
     * Ambil semua permissions dan cache di memory (per-request).
     */
    public static function allCached(): \Illuminate\Support\Collection
    {
        static $cache = null;
        if ($cache === null) {
            $cache = static::all()->keyBy('module_name');
        }
        return $cache;
    }

    /**
     * Cek apakah role boleh akses module_name tertentu.
     * Default: boleh (jika belum ada record di DB).
     */
    public static function roleCanAccess(string $moduleName, string $role): bool
    {
        $perm = static::allCached()->get($moduleName);
        if (!$perm) {
            return true; // default: semua bisa akses jika belum dikonfigurasi
        }
        return $perm->isAllowed($role);
    }
}
