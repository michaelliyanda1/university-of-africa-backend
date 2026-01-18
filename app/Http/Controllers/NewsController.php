<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('author')->published();

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        return response()->json(
            $query->orderBy('published_at', 'desc')->paginate(9)
        );
    }

    public function show(News $news)
    {
        if ($news->status !== 'published') {
            return response()->json(['message' => 'News not found'], 404);
        }

        $news->incrementViews();
        
        return response()->json($news->load('author'));
    }

    public function latest()
    {
        return response()->json(
            News::published()
                ->orderBy('published_at', 'desc')
                ->limit(3)
                ->get()
        );
    }
}
