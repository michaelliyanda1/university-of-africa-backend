<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use Illuminate\Http\Request;

class HeroSlidePublicController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::where('is_active', true)
            ->orderBy('order')
            ->get();

        return response()->json($slides);
    }
}
