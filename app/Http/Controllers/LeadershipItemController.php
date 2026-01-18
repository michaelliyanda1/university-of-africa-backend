<?php

namespace App\Http\Controllers;

use App\Models\LeadershipItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LeadershipItemController extends Controller
{
    public function index(Request $request)
    {
        $query = LeadershipItem::active();

        if ($request->has('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('bio', 'like', "%{$search}%");
            });
        }

        $leadership = $query->ordered()->get();
        
        return response()->json($leadership);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'category' => 'required|in:executive,academic,administrative',
            'bio' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'linkedin' => 'nullable|url',
            'twitter' => 'nullable|url',
            'expertise' => 'nullable',
            'achievements' => 'nullable',
            'quote' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('image');
        
        // Handle JSON strings for expertise and achievements
        if (isset($data['expertise']) && is_string($data['expertise'])) {
            $data['expertise'] = json_decode($data['expertise'], true);
        }
        if (isset($data['achievements']) && is_string($data['achievements'])) {
            $data['achievements'] = json_decode($data['achievements'], true);
        }
        
        // Handle is_active as boolean
        if (isset($data['is_active'])) {
            $data['is_active'] = filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $filePath = $image->storeAs('leadership', $fileName, 'public');
            $data['image'] = $filePath;
        }

        $leadershipItem = LeadershipItem::create($data);

        return response()->json($leadershipItem, 201);
    }

    public function show($id)
    {
        $leadershipItem = LeadershipItem::findOrFail($id);
        return response()->json($leadershipItem);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'category' => 'required|in:executive,academic,administrative',
            'bio' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'linkedin' => 'nullable|url',
            'twitter' => 'nullable|url',
            'expertise' => 'nullable',
            'achievements' => 'nullable',
            'quote' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $leadershipItem = LeadershipItem::findOrFail($id);
        
        $data = $request->except('image');
        
        // Handle JSON strings for expertise and achievements
        if (isset($data['expertise']) && is_string($data['expertise'])) {
            $data['expertise'] = json_decode($data['expertise'], true);
        }
        if (isset($data['achievements']) && is_string($data['achievements'])) {
            $data['achievements'] = json_decode($data['achievements'], true);
        }
        
        // Handle is_active as boolean
        if (isset($data['is_active'])) {
            $data['is_active'] = filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN);
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($leadershipItem->image) {
                Storage::disk('public')->delete($leadershipItem->image);
            }

            $image = $request->file('image');
            $fileName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $filePath = $image->storeAs('leadership', $fileName, 'public');
            $data['image'] = $filePath;
        }

        $leadershipItem->update($data);

        return response()->json($leadershipItem);
    }

    public function destroy($id)
    {
        $leadershipItem = LeadershipItem::findOrFail($id);
        
        // Delete image if exists
        if ($leadershipItem->image) {
            Storage::disk('public')->delete($leadershipItem->image);
        }

        $leadershipItem->delete();

        return response()->json(null, 204);
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:leadership_items,id',
            'items.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->items as $item) {
            LeadershipItem::where('id', $item['id'])
                ->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['message' => 'Leadership items reordered successfully']);
    }
}
