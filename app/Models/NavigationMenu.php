<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'location',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(NavigationItem::class, 'menu_id');
    }

    public function rootItems()
    {
        return $this->hasMany(NavigationItem::class, 'menu_id')
            ->whereNull('parent_id')
            ->orderBy('order');
    }
}
