<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'title',
        'content',
        'data',
        'page',
        'order',
        'is_active',
    ];

    protected $casts = [
        'data' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForPage($query, $page)
    {
        return $query->where('page', $page);
    }
}
