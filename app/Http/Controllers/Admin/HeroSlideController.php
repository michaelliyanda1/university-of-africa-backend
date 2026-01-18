<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    public function index()
    {
        return response()->json(HeroSlide::orderBy('order')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'button_text' => 'required|string',
            'button_link' => 'nullable|string',
            'image_path' => 'nullable|image|max:5120',
            'video_path' => 'nullable|file|mimes:mp4,webm,mov|max:10240',
            'media_type' => 'required|in:image,video',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('slides', 'public');
        }
        
        if ($request->hasFile('video_path')) {
            $validated['video_path'] = $request->file('video_path')->store('slides/videos', 'public');
            $validated['media_type'] = 'video';
        }
        
        if (!isset($validated['order'])) {
            $validated['order'] = HeroSlide::max('order') + 1;
        }

        $slide = HeroSlide::create($validated);

        return response()->json([
            'message' => 'Hero slide created successfully',
            'slide' => $slide
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $slide = HeroSlide::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'button_text' => 'sometimes|required|string',
            'button_link' => 'nullable|string',
            'image_path' => 'nullable|image|max:5120',
            'video_path' => 'nullable|file|mimes:mp4,webm,mov|max:10240',
            'media_type' => 'sometimes|in:image,video',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image_path')) {
            if ($slide->image_path) {
                Storage::disk('public')->delete($slide->image_path);
            }
            $validated['image_path'] = $request->file('image_path')->store('slides', 'public');
            $validated['media_type'] = 'image';
        }
        
        if ($request->hasFile('video_path')) {
            if ($slide->video_path) {
                Storage::disk('public')->delete($slide->video_path);
            }
            $validated['video_path'] = $request->file('video_path')->store('slides/videos', 'public');
            $validated['media_type'] = 'video';
        }

        $slide->update($validated);

        return response()->json([
            'message' => 'Hero slide updated successfully',
            'slide' => $slide
        ]);
    }

    public function destroy($id)
    {
        $slide = HeroSlide::findOrFail($id);
        
        if ($slide->image_path) {
            Storage::disk('public')->delete($slide->image_path);
        }
        
        $slide->delete();

        return response()->json(['message' => 'Slide deleted successfully']);
    }
    
    public function show($id)
    {
        $slide = HeroSlide::findOrFail($id);
        return response()->json($slide);
    }
    
    public function toggleStatus($id)
    {
        $slide = HeroSlide::findOrFail($id);
        $slide->update(['is_active' => !$slide->is_active]);

        return response()->json([
            'message' => 'Hero slide status updated successfully',
            'slide' => $slide
        ]);
    }
    
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'slides' => 'required|array',
            'slides.*.id' => 'required|exists:hero_slides,id',
            'slides.*.order' => 'required|integer',
        ]);

        foreach ($validated['slides'] as $slideData) {
            HeroSlide::where('id', $slideData['id'])->update([
                'order' => $slideData['order'],
            ]);
        }

        return response()->json([
            'message' => 'Hero slides reordered successfully'
        ]);
    }
    
    public function stats()
    {
        $stats = [
            'total' => HeroSlide::count(),
            'active' => HeroSlide::where('is_active', true)->count(),
            'inactive' => HeroSlide::where('is_active', false)->count(),
        ];

        return response()->json($stats);
    }
}
