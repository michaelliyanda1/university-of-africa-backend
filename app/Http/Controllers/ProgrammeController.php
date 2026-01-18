<?php

namespace App\Http\Controllers;

use App\Models\Programme;
use Illuminate\Http\Request;

class ProgrammeController extends Controller
{
    public function index(Request $request)
    {
        $query = Programme::query();

        if ($request->has('level')) {
            $query->where('level', $request->level);
        }

        if ($request->has('school')) {
            $query->where('school', $request->school);
        }

        return response()->json(
            $query->where('is_active', true)->orderBy('order')->orderBy('title')->get()
        );
    }

    public function show(Programme $programme)
    {
        return response()->json($programme);
    }

    public function featured()
    {
        return response()->json(
            Programme::where('is_active', true)
                ->where('is_featured', true)
                ->orderBy('order')
                ->limit(6)
                ->get()
        );
    }
}
