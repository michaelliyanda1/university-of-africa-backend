<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        return response()->json(
            Testimonial::active()
                ->orderBy('order')
                ->orderBy('created_at', 'desc')
                ->get()
        );
    }

    public function featured()
    {
        return response()->json(
            Testimonial::active()
                ->featured()
                ->orderBy('order')
                ->limit(5)
                ->get()
        );
    }
}
