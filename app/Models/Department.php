<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'code',
        'head_of_department',
        'email',
        'phone',
        'image',
        'featured_image',
        'announcements',
        'downloads',
        'news_links',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'announcements' => 'array',
        'downloads' => 'array',
        'news_links' => 'array',
    ];

    public function communities()
    {
        return $this->hasMany(Community::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
