<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        return response()->json(
            Feature::active()->orderBy('order')->get()
        );
    }
}
