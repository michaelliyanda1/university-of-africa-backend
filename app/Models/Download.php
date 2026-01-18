<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;

    protected $fillable = [
        'research_item_id',
        'user_id',
        'ip_address',
        'user_agent',
        'country',
        'city',
    ];

    public function researchItem()
    {
        return $this->belongsTo(ResearchItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
