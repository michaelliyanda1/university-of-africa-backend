<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function roles()
    {
        return $this->belongsToMany(
            config('auth.providers.users.model'),
            'role_permissions',
            'permission_id',
            'role'
        );
    }
}
