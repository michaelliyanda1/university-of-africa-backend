<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Partner::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $partners = $query->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($partners);
    }

    public function show($id)
    {
        $partner = Partner::findOrFail($id);
        return response()->json($partner);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:academic,corporate,government,international',
            'website_url' => 'nullable|url',
            'logo_path' => 'required|image|max:2048',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('logo_path')) {
            $path = $request->file('logo_path')->store('partners', 'public');
            $validated['logo_path'] = $path;
        }

        if (!isset($validated['order'])) {
            $validated['order'] = Partner::max('order') + 1;
        }

        $partner = Partner::create($validated);

        return response()->json([
            'message' => 'Partner created successfully',
            'partner' => $partner
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|string|in:academic,corporate,government,international',
            'website_url' => 'nullable|url',
            'logo_path' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('logo_path')) {
            if ($partner->logo_path) {
                Storage::disk('public')->delete($partner->logo_path);
            }
            $path = $request->file('logo_path')->store('partners', 'public');
            $validated['logo_path'] = $path;
        }

        $partner->update($validated);

        return response()->json([
            'message' => 'Partner updated successfully',
            'partner' => $partner
        ]);
    }

    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        
        if ($partner->logo_path) {
            Storage::disk('public')->delete($partner->logo_path);
        }

        $partner->delete();

        return response()->json([
            'message' => 'Partner deleted successfully'
        ]);
    }

    public function toggleStatus($id)
    {
        $partner = Partner::findOrFail($id);
        $partner->update(['is_active' => !$partner->is_active]);

        return response()->json([
            'message' => 'Partner status updated successfully',
            'partner' => $partner
        ]);
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'partners' => 'required|array',
            'partners.*.id' => 'required|exists:partners,id',
            'partners.*.order' => 'required|integer',
        ]);

        foreach ($validated['partners'] as $partnerData) {
            Partner::where('id', $partnerData['id'])->update([
                'order' => $partnerData['order'],
            ]);
        }

        return response()->json([
            'message' => 'Partners reordered successfully'
        ]);
    }

    public function stats()
    {
        $stats = [
            'total' => Partner::count(),
            'active' => Partner::where('is_active', true)->count(),
            'inactive' => Partner::where('is_active', false)->count(),
            'by_category' => [
                'academic' => Partner::where('category', 'academic')->count(),
                'corporate' => Partner::where('category', 'corporate')->count(),
                'government' => Partner::where('category', 'government')->count(),
                'international' => Partner::where('category', 'international')->count(),
            ],
        ];

        return response()->json($stats);
    }
}
