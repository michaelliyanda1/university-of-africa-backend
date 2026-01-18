<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Video::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('caption', 'like', "%{$search}%");
            });
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $videos = $query->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($videos);
    }

    public function show($id)
    {
        $video = Video::findOrFail($id);
        return response()->json($video);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'caption' => 'required|string|max:255',
            'video_url' => 'required|url',
            'thumbnail_url' => 'nullable|url',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if (!isset($validated['order'])) {
            $validated['order'] = Video::max('order') + 1;
        }

        $video = Video::create($validated);

        return response()->json([
            'message' => 'Video created successfully',
            'video' => $video
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'caption' => 'sometimes|required|string|max:255',
            'video_url' => 'sometimes|required|url',
            'thumbnail_url' => 'nullable|url',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $video->update($validated);

        return response()->json([
            'message' => 'Video updated successfully',
            'video' => $video
        ]);
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();

        return response()->json([
            'message' => 'Video deleted successfully'
        ]);
    }

    public function toggleStatus($id)
    {
        $video = Video::findOrFail($id);
        $video->update(['is_active' => !$video->is_active]);

        return response()->json([
            'message' => 'Video status updated successfully',
            'video' => $video
        ]);
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'videos' => 'required|array',
            'videos.*.id' => 'required|exists:videos,id',
            'videos.*.order' => 'required|integer',
        ]);

        foreach ($validated['videos'] as $videoData) {
            Video::where('id', $videoData['id'])->update([
                'order' => $videoData['order'],
            ]);
        }

        return response()->json([
            'message' => 'Videos reordered successfully'
        ]);
    }

    public function stats()
    {
        $stats = [
            'total' => Video::count(),
            'active' => Video::where('is_active', true)->count(),
            'inactive' => Video::where('is_active', false)->count(),
        ];

        return response()->json($stats);
    }
}
