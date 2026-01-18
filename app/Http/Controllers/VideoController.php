<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    public function index()
    {
        return response()->json(
            DB::table('videos')->where('is_active', true)->orderBy('order')->get()
        );
    }
}
