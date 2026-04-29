<?php

namespace App\Modules\Contact\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected  $table = 'hubungi_kami';
    protected  $primaryKey = 'hubungi_kami_id';

    protected  $fillable = [
        'hubungi_kami_nama', 'hubungi_kami_email', 'hubungi_kami_subjek',
        'hubungi_kami_pesan', 'hubungi_kami_status', 'hubungi_kami_balasan_admin',
        'hubungi_kami_dibalas_pada', 'hubungi_kami_ip_address',
    ];

    protected  $casts = [
        'hubungi_kami_dibalas_pada' => 'datetime',
    ];

    public function scopeNew() { return $this->where('hubungi_kami_status', 'baru'); }
    public function scopeRead() { return $this->where('hubungi_kami_status', 'dibaca'); }
    public function scopeReplied() { return $this->where('hubungi_kami_status', 'dibalas'); }

    public function isNew() { return $this->hubungi_kami_status === 'baru'; }
    public function isRead() { return $this->hubungi_kami_status === 'dibaca'; }
    public function isReplied() { return $this->hubungi_kami_status === 'dibalas'; }

    public function markAsRead()
    {
        $this->update(['hubungi_kami_status' => 'dibaca']);
    }

    public function markAsReplied()
    {
        $this->update([
            'hubungi_kami_status' => 'dibalas',
            'hubungi_kami_dibalas_pada' => now(),
        ]);
    }

    public function getStatusBadgeAttribute()
    {
         $statusBadges = [
            'baru' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Baru</span>',
            'dibaca' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Dibaca</span>',
            'dibalas' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Dibalas</span>',
        ];
        return $statusBadges[$this->hubungi_kami_status] ?? '';
    }
}
