<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'community_id',
        'image',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function researchItems()
    {
        return $this->hasMany(ResearchItem::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
