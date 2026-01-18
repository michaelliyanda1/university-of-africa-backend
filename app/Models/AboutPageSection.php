<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutPageSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_slug',
        'section_key',
        'title',
        'subtitle',
        'description',
        'icon',
        'color',
        'items',
        'image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'items' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByPage($query, $pageSlug)
    {
        return $query->where('page_slug', $pageSlug);
    }

    public function scopeBySection($query, $sectionKey)
    {
        return $query->where('section_key', $sectionKey);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
