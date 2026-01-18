<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class LeadershipItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'category',
        'bio',
        'email',
        'phone',
        'linkedin',
        'twitter',
        'expertise',
        'achievements',
        'quote',
        'image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'expertise' => 'array',
        'achievements' => 'array',
        'is_active' => 'boolean',
    ];

    protected function imageUrl(): Attribute
    {
        return Attribute::get(function () {
            if ($this->image) {
                return url('storage/' . $this->image);
            }
            return 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop&auto=format';
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
