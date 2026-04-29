<?php

namespace App\Modules\User\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Modules\Post\Models\Post;
use App\Modules\Product\Models\Product;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin (Admin or above)
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'super_admin', 'developer']);
    }

    /**
     * Check if user is super admin (Super Admin or above)
     */
    public function isSuperAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'developer']);
    }

    /**
     * Check if user is developer
     */
    public function isDeveloper(): bool
    {
        return $this->role === 'developer';
    }

    /**
     * Check if user can manage other users
     */
    public function canManageUsers(): bool
    {
        return $this->isSuperAdmin();
    }

    /**
     * Check if user can edit/delete another user
     */
    public function canModifyUser(User $user): bool
    {
        // Developer can modify anyone
        if ($this->isDeveloper()) {
            return true;
        }

        // Super Admin (not Developer) can only modify Admin users, not Developer or Super Admin
        if ($this->isSuperAdmin() && !$this->isDeveloper()) {
            return $user->role === 'admin';
        }

        return false;
    }

    /**
     * Get the posts for the user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the products for the user.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
