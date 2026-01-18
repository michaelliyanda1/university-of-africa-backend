<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        return response()->json(
            Partner::where('is_active', true)->orderBy('order')->get()
        );
    }
}
