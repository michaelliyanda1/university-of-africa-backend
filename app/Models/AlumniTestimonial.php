<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniTestimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumni_id',
        'alumni_name',
        'position',
        'content',
        'rating',
        'likes',
        'comments',
        'approved',
        'approved_at',
        'order'
    ];

    protected $casts = [
        'rating' => 'integer',
        'likes' => 'integer',
        'comments' => 'integer',
        'approved' => 'boolean',
        'approved_at' => 'datetime',
        'order' => 'integer'
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at', 'desc');
    }
}
