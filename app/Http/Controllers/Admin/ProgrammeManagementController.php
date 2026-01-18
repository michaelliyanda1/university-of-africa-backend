<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgrammeManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Programme::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('school', 'like', "%{$search}%")
                  ->orWhere('level', 'like', "%{$search}%");
            });
        }

        if ($request->has('level')) {
            $query->where('level', $request->level);
        }

        if ($request->has('school')) {
            $query->where('school', $request->school);
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $programmes = $query->orderBy('order')
            ->orderBy('title')
            ->paginate($request->get('per_page', 15));

        return response()->json($programmes);
    }

    public function show(Programme $programme)
    {
        return response()->json($programme);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'level' => 'required|string|in:Certificate,Diploma,Undergraduate,Postgraduate',
            'school' => 'required|string|max:255',
            'duration' => 'required|string|max:100',
            'mode' => 'required|string|in:Full-time,Part-time,Online,Blended',
            'description' => 'required|string',
            'full_description' => 'nullable|string',
            'specializations' => 'nullable|array',
            'entry_requirements' => 'nullable|string',
            'careers' => 'nullable|array',
            'learning_outcomes' => 'nullable|array',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'order' => 'nullable|integer',
        ]);

        // Set default values for boolean fields
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_featured'] = $request->boolean('is_featured', false);

        $validated['slug'] = Str::slug($validated['title']);

        if (!isset($validated['order'])) {
            $validated['order'] = Programme::max('order') + 1;
        }

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/programmes'), $imageName);
            $validated['featured_image'] = 'programmes/' . $imageName;
        }

        // Handle array fields
        $arrayFields = ['specializations', 'careers', 'learning_outcomes'];
        foreach ($arrayFields as $field) {
            if (isset($validated[$field]) && is_array($validated[$field])) {
                $validated[$field] = json_encode($validated[$field]);
            }
        }

        $programme = Programme::create($validated);

        return response()->json([
            'message' => 'Programme created successfully',
            'programme' => $programme
        ], 201);
    }

    public function update(Request $request, Programme $programme)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'level' => 'sometimes|required|string|in:Certificate,Diploma,Undergraduate,Postgraduate',
            'school' => 'sometimes|required|string|max:255',
            'duration' => 'sometimes|required|string|max:100',
            'mode' => 'sometimes|required|string|in:Full-time,Part-time,Online,Blended',
            'description' => 'sometimes|required|string',
            'full_description' => 'nullable|string',
            'specializations' => 'nullable|array',
            'entry_requirements' => 'nullable|string',
            'careers' => 'nullable|array',
            'learning_outcomes' => 'nullable|array',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_featured_image' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'order' => 'nullable|integer',
        ]);

        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle image removal
        if ($request->boolean('remove_featured_image')) {
            if ($programme->featured_image) {
                $oldImagePath = public_path('storage/' . $programme->featured_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $validated['featured_image'] = null;
        }

        // Handle new image upload
        if ($request->hasFile('featured_image')) {
            // Remove old image if exists
            if ($programme->featured_image) {
                $oldImagePath = public_path('storage/' . $programme->featured_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            $image = $request->file('featured_image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/programmes'), $imageName);
            $validated['featured_image'] = 'programmes/' . $imageName;
        }

        // Handle array fields
        $arrayFields = ['specializations', 'careers', 'learning_outcomes'];
        foreach ($arrayFields as $field) {
            if (isset($validated[$field]) && is_array($validated[$field])) {
                $validated[$field] = json_encode($validated[$field]);
            }
        }

        $programme->update($validated);

        return response()->json([
            'message' => 'Programme updated successfully',
            'programme' => $programme
        ]);
    }

    public function destroy(Programme $programme)
    {
        $programme->delete();

        return response()->json([
            'message' => 'Programme deleted successfully'
        ]);
    }

    public function toggleStatus(Programme $programme)
    {
        $programme->update(['is_active' => !$programme->is_active]);

        return response()->json([
            'message' => 'Programme status updated successfully',
            'programme' => $programme
        ]);
    }

    public function toggleFeatured(Programme $programme)
    {
        $programme->update(['is_featured' => !$programme->is_featured]);

        return response()->json([
            'message' => 'Programme featured status updated successfully',
            'programme' => $programme
        ]);
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'programmes' => 'required|array',
            'programmes.*.id' => 'required|exists:programmes,id',
            'programmes.*.order' => 'required|integer',
        ]);

        foreach ($validated['programmes'] as $programmeData) {
            Programme::where('id', $programmeData['id'])->update([
                'order' => $programmeData['order'],
            ]);
        }

        return response()->json([
            'message' => 'Programmes reordered successfully'
        ]);
    }

    public function stats()
    {
        $stats = [
            'total' => Programme::count(),
            'active' => Programme::where('is_active', true)->count(),
            'inactive' => Programme::where('is_active', false)->count(),
            'featured' => Programme::where('is_featured', true)->count(),
            'by_level' => [
                'certificate' => Programme::where('level', 'Certificate')->count(),
                'diploma' => Programme::where('level', 'Diploma')->count(),
                'undergraduate' => Programme::where('level', 'Undergraduate')->count(),
                'postgraduate' => Programme::where('level', 'Postgraduate')->count(),
            ],
        ];

        return response()->json($stats);
    }
}
