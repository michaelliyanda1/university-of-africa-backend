<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use App\Models\CmsSection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CmsPageManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = CmsPage::with(['creator', 'updater']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $pages = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($pages);
    }

    public function show($id)
    {
        $page = CmsPage::with(['creator', 'updater'])->findOrFail($id);
        return response()->json($page);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['created_by'] = auth()->id();

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('cms-pages', 'public');
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        $page = CmsPage::create($validated);

        return response()->json([
            'message' => 'CMS page created successfully',
            'page' => $page
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $page = CmsPage::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'sometimes|required|in:draft,published',
        ]);

        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('featured_image')) {
            if ($page->featured_image) {
                Storage::disk('public')->delete($page->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('cms-pages', 'public');
        }

        $validated['updated_by'] = auth()->id();

        if (isset($validated['status']) && $validated['status'] === 'published' && !$page->published_at) {
            $validated['published_at'] = now();
        }

        $page->update($validated);

        return response()->json([
            'message' => 'CMS page updated successfully',
            'page' => $page
        ]);
    }

    public function destroy($id)
    {
        $page = CmsPage::findOrFail($id);
        
        if ($page->featured_image) {
            Storage::disk('public')->delete($page->featured_image);
        }
        
        $page->delete();

        return response()->json([
            'message' => 'CMS page deleted successfully'
        ]);
    }

    public function getSections($pageSlug)
    {
        $sections = CmsSection::where('page', $pageSlug)
            ->orderBy('order')
            ->get();

        return response()->json($sections);
    }

    public function updateSection(Request $request, $id)
    {
        $section = CmsSection::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'data' => 'sometimes|array',
            'is_active' => 'boolean',
        ]);

        $section->update($validated);

        return response()->json([
            'message' => 'Section updated successfully',
            'section' => $section
        ]);
    }

    public function stats()
    {
        $stats = [
            'total' => CmsPage::count(),
            'published' => CmsPage::where('status', 'published')->count(),
            'draft' => CmsPage::where('status', 'draft')->count(),
        ];

        return response()->json($stats);
    }
}
