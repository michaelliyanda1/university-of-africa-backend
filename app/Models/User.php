<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department_id',
        'phone',
        'bio',
        'avatar',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function researchItems()
    {
        return $this->hasMany(ResearchItem::class, 'submitted_by');
    }

    public function approvedResearch()
    {
        return $this->hasMany(ResearchItem::class, 'approved_by');
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStaff()
    {
        return in_array($this->role, ['admin', 'staff']);
    }
}
