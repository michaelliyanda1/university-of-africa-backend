<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Feature::query();

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

        $features = $query->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($features);
    }

    public function show($id)
    {
        $feature = Feature::findOrFail($id);
        return response()->json($feature);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:100',
            'color_from' => 'required|string|max:50',
            'color_to' => 'required|string|max:50',
            'icon_bg' => 'required|string|max:50',
            'icon_color' => 'required|string|max:50',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if (!isset($validated['order'])) {
            $validated['order'] = Feature::max('order') + 1;
        }

        $feature = Feature::create($validated);

        return response()->json([
            'message' => 'Feature created successfully',
            'feature' => $feature
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $feature = Feature::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'icon' => 'sometimes|required|string|max:100',
            'color_from' => 'sometimes|required|string|max:50',
            'color_to' => 'sometimes|required|string|max:50',
            'icon_bg' => 'sometimes|required|string|max:50',
            'icon_color' => 'sometimes|required|string|max:50',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $feature->update($validated);

        return response()->json([
            'message' => 'Feature updated successfully',
            'feature' => $feature
        ]);
    }

    public function destroy($id)
    {
        $feature = Feature::findOrFail($id);
        $feature->delete();

        return response()->json([
            'message' => 'Feature deleted successfully'
        ]);
    }

    public function toggleStatus($id)
    {
        $feature = Feature::findOrFail($id);
        $feature->update(['is_active' => !$feature->is_active]);

        return response()->json([
            'message' => 'Feature status updated successfully',
            'feature' => $feature
        ]);
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'features' => 'required|array',
            'features.*.id' => 'required|exists:features,id',
            'features.*.order' => 'required|integer',
        ]);

        foreach ($validated['features'] as $featureData) {
            Feature::where('id', $featureData['id'])->update([
                'order' => $featureData['order'],
            ]);
        }

        return response()->json([
            'message' => 'Features reordered successfully'
        ]);
    }

    public function stats()
    {
        $stats = [
            'total' => Feature::count(),
            'active' => Feature::where('is_active', true)->count(),
            'inactive' => Feature::where('is_active', false)->count(),
        ];

        return response()->json($stats);
    }
}
