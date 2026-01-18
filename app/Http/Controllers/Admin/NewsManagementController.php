<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('author');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $news = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($news);
    }

    public function show($id)
    {
        $news = News::with('author')->findOrFail($id);
        return response()->json($news);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['author_id'] = auth()->id();

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('news', 'public');
            $validated['featured_image'] = $path;
        }

        if ($validated['status'] === 'published' && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $news = News::create($validated);

        return response()->json([
            'message' => 'News article created successfully',
            'news' => $news->load('author')
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'excerpt' => 'sometimes|required|string|max:500',
            'content' => 'sometimes|required|string',
            'category' => 'sometimes|required|string|max:100',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'sometimes|required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);

        $news = News::findOrFail($id);
        
        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('featured_image')) {
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $path = $request->file('featured_image')->store('news', 'public');
            $validated['featured_image'] = $path;
        }

        if (isset($validated['status']) && $validated['status'] === 'published' && !$news->published_at && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $news->update($validated);

        return response()->json([
            'message' => 'News article updated successfully',
            'news' => $news->load('author')
        ]);
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        $news->delete();

        return response()->json([
            'message' => 'News article deleted successfully'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,published',
        ]);

        $news = News::findOrFail($id);
        
        if ($validated['status'] === 'published' && !$news->published_at) {
            $validated['published_at'] = now();
        }

        $news->update($validated);

        return response()->json([
            'message' => 'News status updated successfully',
            'news' => $news
        ]);
    }

    public function stats()
    {
        $stats = [
            'total' => News::count(),
            'published' => News::where('status', 'published')->count(),
            'draft' => News::where('status', 'draft')->count(),
            'total_views' => News::sum('views'),
            'by_category' => News::selectRaw('category, COUNT(*) as count')
                ->groupBy('category')
                ->pluck('count', 'category')
                ->toArray(),
        ];

        return response()->json($stats);
    }
}
