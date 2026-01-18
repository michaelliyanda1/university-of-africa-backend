<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResearchItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'abstract',
        'authors',
        'keywords',
        'collection_id',
        'submitted_by',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
        'publication_date',
        'doi',
        'isbn',
        'issn',
        'status',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'download_count',
        'view_count',
        'is_featured',
    ];

    protected $casts = [
        'authors' => 'array',
        'keywords' => 'array',
        'publication_date' => 'date',
        'approved_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
