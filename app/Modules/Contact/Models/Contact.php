<?php

namespace App\Modules\Contact\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\User\Models\User;
use App\Modules\Category\Models\Category;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'user_id',
        'category_id',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'active' => 'badge-success',
            'draft' => 'badge-warning',
            'archived' => 'badge-secondary',
            default => 'badge-danger',
        };
    }
}
