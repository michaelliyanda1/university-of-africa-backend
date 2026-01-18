<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromotionalAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionalAdManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = PromotionalAd::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $ads = $query->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($ads);
    }

    public function show($id)
    {
        $ad = PromotionalAd::findOrFail($id);
        return response()->json($ad);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link_url' => 'nullable|url',
            'image_path' => 'required|image|max:2048',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('promotional-ads', 'public');
            $validated['image_path'] = $path;
        }

        if (!isset($validated['order'])) {
            $validated['order'] = PromotionalAd::max('order') + 1;
        }

        $ad = PromotionalAd::create($validated);

        return response()->json([
            'message' => 'Promotional ad created successfully',
            'ad' => $ad
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $ad = PromotionalAd::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link_url' => 'nullable|url',
            'image_path' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image_path')) {
            if ($ad->image_path) {
                Storage::disk('public')->delete($ad->image_path);
            }
            $path = $request->file('image_path')->store('promotional-ads', 'public');
            $validated['image_path'] = $path;
        }

        $ad->update($validated);

        return response()->json([
            'message' => 'Promotional ad updated successfully',
            'ad' => $ad
        ]);
    }

    public function destroy($id)
    {
        $ad = PromotionalAd::findOrFail($id);
        
        if ($ad->image_path) {
            Storage::disk('public')->delete($ad->image_path);
        }

        $ad->delete();

        return response()->json([
            'message' => 'Promotional ad deleted successfully'
        ]);
    }

    public function toggleStatus($id)
    {
        $ad = PromotionalAd::findOrFail($id);
        $ad->update(['is_active' => !$ad->is_active]);

        return response()->json([
            'message' => 'Promotional ad status updated successfully',
            'ad' => $ad
        ]);
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'ads' => 'required|array',
            'ads.*.id' => 'required|exists:promotional_ads,id',
            'ads.*.order' => 'required|integer',
        ]);

        foreach ($validated['ads'] as $adData) {
            PromotionalAd::where('id', $adData['id'])->update([
                'order' => $adData['order'],
            ]);
        }

        return response()->json([
            'message' => 'Promotional ads reordered successfully'
        ]);
    }

    public function stats()
    {
        $stats = [
            'total' => PromotionalAd::count(),
            'active' => PromotionalAd::where('is_active', true)->count(),
            'inactive' => PromotionalAd::where('is_active', false)->count(),
        ];

        return response()->json($stats);
    }
}
