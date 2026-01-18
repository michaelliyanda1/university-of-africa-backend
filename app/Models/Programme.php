<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'level',
        'school',
        'duration',
        'mode',
        'description',
        'full_description',
        'specializations',
        'entry_requirements',
        'careers',
        'learning_outcomes',
        'featured_image',
        'is_active',
        'is_featured',
        'order',
    ];

    protected $casts = [
        'specializations' => 'array',
        'careers' => 'array',
        'learning_outcomes' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
