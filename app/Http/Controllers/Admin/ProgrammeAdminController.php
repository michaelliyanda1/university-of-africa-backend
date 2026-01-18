<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgrammeAdminController extends Controller
{
    public function index()
    {
        return response()->json(Programme::orderBy('order')->orderBy('title')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'level' => 'required|in:diploma,undergraduate,postgraduate',
            'school' => 'required|string',
            'duration' => 'required|string',
            'mode' => 'required|string',
            'description' => 'required|string',
            'full_description' => 'required|string',
            'entry_requirements' => 'required|string',
        ]);

        $programme = Programme::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'level' => $request->level,
            'school' => $request->school,
            'duration' => $request->duration,
            'mode' => $request->mode,
            'description' => $request->description,
            'full_description' => $request->full_description,
            'specializations' => $request->specializations,
            'entry_requirements' => $request->entry_requirements,
            'careers' => $request->careers,
            'learning_outcomes' => $request->learning_outcomes,
            'is_active' => $request->is_active ?? true,
            'is_featured' => $request->is_featured ?? false,
            'order' => $request->order ?? 0,
        ]);

        return response()->json($programme, 201);
    }

    public function update(Request $request, Programme $programme)
    {
        $programme->update($request->all());
        return response()->json($programme);
    }

    public function destroy(Programme $programme)
    {
        $programme->delete();
        return response()->json(['message' => 'Programme deleted successfully']);
    }
}
