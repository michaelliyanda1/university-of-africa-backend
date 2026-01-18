<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'graduation_year',
        'degree',
        'current_position',
        'company',
        'location',
        'linkedin_url',
        'bio',
        'profile_image',
        'reaction_image',
        'is_featured',
        'approved',
        'approved_at',
        'order'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'approved' => 'boolean',
        'approved_at' => 'datetime',
        'graduation_year' => 'integer',
        'order' => 'integer'
    ];

    public function testimonials()
    {
        return $this->hasMany(AlumniTestimonial::class);
    }

    public function approvedTestimonials()
    {
        return $this->testimonials()->where('approved', true)->orderBy('order');
    }

    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('graduation_year', 'desc');
    }
}
