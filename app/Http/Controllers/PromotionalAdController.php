<?php

namespace App\Http\Controllers;

use App\Models\PromotionalAd;
use Illuminate\Http\Request;

class PromotionalAdController extends Controller
{
    public function index()
    {
        return response()->json(
            PromotionalAd::active()->orderBy('order')->get()
        );
    }
}
