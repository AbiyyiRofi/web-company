<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'is_active'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    public function isSuperAdmin(): bool
    {
        return in_array(strtolower($this->role ?? ''), ['superadmin', 'super_admin']);
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}
