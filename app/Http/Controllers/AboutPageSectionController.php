<?php

namespace App\Http\Controllers;

use App\Models\AboutPageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AboutPageSectionController extends Controller
{
    public function index(Request $request)
    {
        $query = AboutPageSection::active();

        if ($request->has('page_slug')) {
            $query->byPage($request->page_slug);
        }

        if ($request->has('section_key')) {
            $query->bySection($request->section_key);
        }

        $sections = $query->ordered()->get();
        
        return response()->json($sections);
    }

    public function getByPage($pageSlug)
    {
        $sections = AboutPageSection::active()
            ->byPage($pageSlug)
            ->ordered()
            ->get();
        
        return response()->json($sections);
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_slug' => 'required|string|max:255',
            'section_key' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'items' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('image');
        
        // Handle JSON strings for items
        if (isset($data['items']) && is_string($data['items'])) {
            $data['items'] = json_decode($data['items'], true);
        }
        
        // Handle is_active as boolean
        if (isset($data['is_active'])) {
            $data['is_active'] = filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . Str::slug($request->section_key) . '.' . $image->getClientOriginalExtension();
            $filePath = $image->storeAs('about-pages', $fileName, 'public');
            $data['image'] = $filePath;
        }

        $section = AboutPageSection::create($data);

        return response()->json($section, 201);
    }

    public function show($id)
    {
        $section = AboutPageSection::findOrFail($id);
        return response()->json($section);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'page_slug' => 'required|string|max:255',
            'section_key' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'items' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $section = AboutPageSection::findOrFail($id);
        
        $data = $request->except('image');
        
        // Handle JSON strings for items
        if (isset($data['items']) && is_string($data['items'])) {
            $data['items'] = json_decode($data['items'], true);
        }
        
        // Handle is_active as boolean
        if (isset($data['is_active'])) {
            $data['is_active'] = filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN);
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($section->image) {
                Storage::disk('public')->delete($section->image);
            }

            $image = $request->file('image');
            $fileName = time() . '_' . Str::slug($request->section_key) . '.' . $image->getClientOriginalExtension();
            $filePath = $image->storeAs('about-pages', $fileName, 'public');
            $data['image'] = $filePath;
        }

        $section->update($data);

        return response()->json($section);
    }

    public function destroy($id)
    {
        $section = AboutPageSection::findOrFail($id);
        
        // Delete image if exists
        if ($section->image) {
            Storage::disk('public')->delete($section->image);
        }

        $section->delete();

        return response()->json(null, 204);
    }
}
