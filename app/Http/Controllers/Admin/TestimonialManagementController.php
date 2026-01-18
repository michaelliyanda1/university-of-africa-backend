<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Testimonial::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                  ->orWhere('programme', 'like', "%{$search}%")
                  ->orWhere('current_position', 'like', "%{$search}%");
            });
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->has('is_featured')) {
            $query->where('is_featured', $request->is_featured);
        }

        $testimonials = $query->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($testimonials);
    }

    public function show($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return response()->json($testimonial);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'student_image' => 'nullable|image|max:2048',
            'programme' => 'required|string|max:255',
            'graduation_year' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'testimonial' => 'required|string',
            'current_position' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('student_image')) {
            $path = $request->file('student_image')->store('testimonials', 'public');
            $validated['student_image'] = $path;
        }

        if (!isset($validated['order'])) {
            $validated['order'] = Testimonial::max('order') + 1;
        }

        $testimonial = Testimonial::create($validated);

        return response()->json([
            'message' => 'Testimonial created successfully',
            'testimonial' => $testimonial
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        
        $validated = $request->validate([
            'student_name' => 'sometimes|required|string|max:255',
            'student_image' => 'nullable|image|max:2048',
            'programme' => 'sometimes|required|string|max:255',
            'graduation_year' => 'sometimes|required|integer|min:1900|max:' . (date('Y') + 10),
            'testimonial' => 'sometimes|required|string',
            'current_position' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('student_image')) {
            if ($testimonial->student_image) {
                Storage::disk('public')->delete($testimonial->student_image);
            }
            $path = $request->file('student_image')->store('testimonials', 'public');
            $validated['student_image'] = $path;
        }

        $testimonial->update($validated);

        return response()->json([
            'message' => 'Testimonial updated successfully',
            'testimonial' => $testimonial
        ]);
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        
        if ($testimonial->student_image) {
            Storage::disk('public')->delete($testimonial->student_image);
        }

        $testimonial->delete();

        return response()->json([
            'message' => 'Testimonial deleted successfully'
        ]);
    }

    public function toggleStatus($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update(['is_active' => !$testimonial->is_active]);

        return response()->json([
            'message' => 'Testimonial status updated successfully',
            'testimonial' => $testimonial
        ]);
    }

    public function toggleFeatured($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update(['is_featured' => !$testimonial->is_featured]);

        return response()->json([
            'message' => 'Testimonial featured status updated successfully',
            'testimonial' => $testimonial
        ]);
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'testimonials' => 'required|array',
            'testimonials.*.id' => 'required|exists:testimonials,id',
            'testimonials.*.order' => 'required|integer',
        ]);

        foreach ($validated['testimonials'] as $testimonialData) {
            Testimonial::where('id', $testimonialData['id'])->update([
                'order' => $testimonialData['order'],
            ]);
        }

        return response()->json([
            'message' => 'Testimonials reordered successfully'
        ]);
    }

    public function stats()
    {
        $stats = [
            'total' => Testimonial::count(),
            'active' => Testimonial::where('is_active', true)->count(),
            'inactive' => Testimonial::where('is_active', false)->count(),
            'featured' => Testimonial::where('is_featured', true)->count(),
        ];

        return response()->json($stats);
    }
}
