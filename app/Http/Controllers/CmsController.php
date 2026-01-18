<?php

namespace App\Http\Controllers;

use App\Models\CmsPage;
use App\Models\CmsSection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CmsController extends Controller
{
    public function getPage($slug)
    {
        $page = CmsPage::where('slug', $slug)
            ->published()
            ->firstOrFail();

        return response()->json($page);
    }

    public function getSections($page = 'home')
    {
        $sections = CmsSection::active()
            ->forPage($page)
            ->orderBy('order')
            ->get();

        return response()->json($sections);
    }

    public function updateSection(Request $request, CmsSection $section)
    {
        $this->authorize('update', $section);

        $request->validate([
            'title' => 'sometimes|string',
            'content' => 'sometimes|string',
            'data' => 'sometimes|array',
            'is_active' => 'sometimes|boolean',
        ]);

        $section->update($request->only(['title', 'content', 'data', 'is_active']));

        return response()->json($section);
    }

    public function storePage(Request $request)
    {
        $this->authorize('create', CmsPage::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|array',
            'featured_image' => 'nullable|string',
            'status' => 'required|in:draft,published',
        ]);

        $page = CmsPage::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'featured_image' => $request->featured_image,
            'status' => $request->status,
            'created_by' => $request->user()->id,
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return response()->json($page, 201);
    }
}
