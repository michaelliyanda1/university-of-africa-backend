<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DepartmentManagementController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('communities')
            ->orderBy('order')
            ->get();
        
        return response()->json($departments);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:departments,code',
            'description' => 'nullable|string',
            'head_of_department' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|max:5120',
            'featured_image' => 'nullable|image|max:5120',
            'announcements' => 'nullable|string',
            'downloads' => 'nullable|string',
            'news_links' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
            'order' => 'sometimes|integer',
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('departments', 'public');
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('departments', 'public');
        } else {
            // Keep featured image null if no image uploaded
            $validated['featured_image'] = null;
        }

        // Handle array fields (coming as JSON strings from FormData)
        if (isset($validated['announcements'])) {
            $validated['announcements'] = json_decode($validated['announcements'], true);
        }
        if (isset($validated['downloads'])) {
            $validated['downloads'] = json_decode($validated['downloads'], true);
        }
        if (isset($validated['news_links'])) {
            $validated['news_links'] = json_decode($validated['news_links'], true);
        }

        // Handle boolean fields from FormData
        if (isset($validated['is_active'])) {
            $validated['is_active'] = filter_var($validated['is_active'], FILTER_VALIDATE_BOOLEAN);
        } else {
            $validated['is_active'] = true; // Default to active
        }

        // Handle integer fields from FormData
        if (isset($validated['order'])) {
            $validated['order'] = (int) $validated['order'];
        } else {
            $validated['order'] = Department::max('order') + 1; // Default order
        }

        $department = Department::create($validated);

        return response()->json([
            'message' => 'Department created successfully',
            'department' => $department
        ], 201);
    }

    public function show($id)
    {
        $department = Department::findOrFail($id);
        return response()->json($department->load('communities'));
    }

    public function update(Request $request, $id)
    {
        \Log::info('Department update request received', ['id' => $id, 'data' => $request->all()]);
        
        $department = Department::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'code' => 'sometimes|required|string|max:10|unique:departments,code,' . $department->id,
            'description' => 'nullable|string',
            'head_of_department' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|max:5120',
            'featured_image' => 'nullable|image|max:5120',
            'remove_image' => 'sometimes|boolean',
            'remove_featured_image' => 'sometimes|boolean',
            'announcements' => 'nullable|string',
            'downloads' => 'nullable|string',
            'news_links' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
            'order' => 'sometimes|integer',
        ]);

        \Log::info('Department validation passed', ['validated' => $validated]);

        // Update slug if name changed
        if (isset($validated['name']) && $validated['name'] !== $department->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle image removal
        if ($request->boolean('remove_image')) {
            if ($department->image) {
                Storage::disk('public')->delete($department->image);
            }
            $validated['image'] = null;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($department->image) {
                Storage::disk('public')->delete($department->image);
            }
            $validated['image'] = $request->file('image')->store('departments', 'public');
        } elseif (!$request->hasFile('image') && !$request->has('remove_image')) {
            // Keep existing image if no new image is uploaded and no removal request
            unset($validated['image']);
        }

        // Handle featured image removal
        if ($request->boolean('remove_featured_image')) {
            if ($department->featured_image) {
                Storage::disk('public')->delete($department->featured_image);
            }
            $validated['featured_image'] = null;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old featured image
            if ($department->featured_image) {
                Storage::disk('public')->delete($department->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('departments', 'public');
        } elseif (!$request->hasFile('featured_image') && !$request->has('remove_featured_image')) {
            // Keep existing featured image if no new image is uploaded and no removal request
            unset($validated['featured_image']);
        }

        // Handle array fields (coming as JSON strings from FormData)
        if (isset($validated['announcements'])) {
            $validated['announcements'] = json_decode($validated['announcements'], true);
        }
        if (isset($validated['downloads'])) {
            $validated['downloads'] = json_decode($validated['downloads'], true);
        }
        if (isset($validated['news_links'])) {
            $validated['news_links'] = json_decode($validated['news_links'], true);
        }

        // Handle boolean fields from FormData
        if (isset($validated['is_active'])) {
            $validated['is_active'] = filter_var($validated['is_active'], FILTER_VALIDATE_BOOLEAN);
        }

        // Handle integer fields from FormData
        if (isset($validated['order'])) {
            $validated['order'] = (int) $validated['order'];
        }

        \Log::info('About to update department', ['validated' => $validated]);

        $department->update($validated);

        \Log::info('Department updated successfully', ['department' => $department->toArray()]);

        return response()->json([
            'message' => 'Department updated successfully',
            'department' => $department
        ]);
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        // Delete images
        if ($department->image) {
            Storage::disk('public')->delete($department->image);
        }
        if ($department->featured_image) {
            Storage::disk('public')->delete($department->featured_image);
        }

        $department->delete();

        return response()->json([
            'message' => 'Department deleted successfully'
        ]);
    }

    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'departments' => 'required|array',
            'departments.*.id' => 'required|exists:departments,id',
            'departments.*.order' => 'required|integer',
        ]);

        foreach ($validated['departments'] as $dept) {
            Department::where('id', $dept['id'])->update(['order' => $dept['order']]);
        }

        return response()->json([
            'message' => 'Department order updated successfully'
        ]);
    }
}
