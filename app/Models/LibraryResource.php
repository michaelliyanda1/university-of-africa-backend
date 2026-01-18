<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'category',
        'image_url',
        'link',
        'rating',
        'user_count',
        'featured',
        'status',
        'sort_order'
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'featured' => 'boolean',
        'status' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Scope to get only active resources
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope to get only featured resources
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope to get resources by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope to get resources by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get formatted rating
     */
    public function getFormattedRatingAttribute()
    {
        return number_format($this->rating, 1);
    }

    /**
     * Get available categories
     */
    public static function getCategories()
    {
        return [
            'ebooks' => 'E-Books',
            'courses' => 'Courses',
            'research' => 'Research',
            'journals' => 'Journals',
            'multimedia' => 'Multimedia'
        ];
    }

    /**
     * Get available types
     */
    public static function getTypes()
    {
        return [
            'Downloadable' => 'Downloadable',
            'Online Access' => 'Online Access'
        ];
    }
}
