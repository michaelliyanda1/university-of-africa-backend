<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LibraryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LibraryManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LibraryResource::query();
        
        // Filter by search
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filter by category
        if ($request->has('category') && $request->get('category') !== 'all') {
            $query->where('category', $request->get('category'));
        }
        
        // Filter by type
        if ($request->has('type') && $request->get('type') !== 'all') {
            $query->where('type', $request->get('type'));
        }
        
        // Filter by status
        if ($request->has('status') && $request->get('status') !== 'all') {
            $query->where('status', $request->get('status') === 'active');
        }
        
        // Order by sort_order and then by created_at
        $resources = $query->orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(10);
        
        return response()->json([
            'resources' => $resources,
            'categories' => LibraryResource::getCategories(),
            'types' => LibraryResource::getTypes(),
        ]);
    }

    /**
     * Get statistics for library resources
     */
    public function stats()
    {
        $total = LibraryResource::count();
        $active = LibraryResource::where('status', true)->count();
        $inactive = LibraryResource::where('status', false)->count();
        $featured = LibraryResource::where('featured', true)->count();
        
        $byCategory = LibraryResource::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->get()
            ->pluck('count', 'category')
            ->toArray();
            
        $byType = LibraryResource::selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->get()
            ->pluck('count', 'type')
            ->toArray();

        return response()->json([
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive,
            'featured' => $featured,
            'by_category' => $byCategory,
            'by_type' => $byType,
        ]);
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:Downloadable,Online Access',
            'category' => 'required|in:ebooks,courses,research,journals,multimedia',
            'link' => 'required|url',
            'rating' => 'nullable|numeric|min:0|max:5',
            'user_count' => 'nullable|string|max:20',
            'featured' => 'boolean',
            'status' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('library-resources', $imageName, 'public');
            $data['image_url'] = 'storage/library-resources/' . $imageName;
        } else {
            $data['image_url'] = $request->get('image_url');
        }

        // Set default values
        $data['featured'] = $data['featured'] ?? false;
        $data['status'] = $data['status'] ?? true;
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['rating'] = $data['rating'] ?? 0.00;
        $data['user_count'] = $data['user_count'] ?? '0';

        $resource = LibraryResource::create($data);

        return response()->json([
            'message' => 'Library resource created successfully',
            'resource' => $resource
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(LibraryResource $libraryResource)
    {
        return response()->json(['resource' => $libraryResource]);
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, LibraryResource $libraryResource)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:Downloadable,Online Access',
            'category' => 'required|in:ebooks,courses,research,journals,multimedia',
            'link' => 'required|url',
            'rating' => 'nullable|numeric|min:0|max:5',
            'user_count' => 'nullable|string|max:20',
            'featured' => 'boolean',
            'status' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($libraryResource->image_url) {
                $oldImagePath = str_replace('storage/', '', $libraryResource->image_url);
                Storage::disk('public')->delete($oldImagePath);
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('library-resources', $imageName, 'public');
            $data['image_url'] = 'storage/library-resources/' . $imageName;
        } else {
            $data['image_url'] = $request->get('image_url', $libraryResource->image_url);
        }

        // Set default values
        $data['featured'] = $data['featured'] ?? false;
        $data['status'] = $data['status'] ?? true;
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['rating'] = $data['rating'] ?? 0.00;
        $data['user_count'] = $data['user_count'] ?? '0';

        $libraryResource->update($data);

        return response()->json([
            'message' => 'Library resource updated successfully',
            'resource' => $libraryResource
        ]);
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(LibraryResource $libraryResource)
    {
        // Delete image if exists
        if ($libraryResource->image_url) {
            $imagePath = str_replace('storage/', '', $libraryResource->image_url);
            Storage::disk('public')->delete($imagePath);
        }

        $libraryResource->delete();

        return response()->json([
            'message' => 'Library resource deleted successfully'
        ]);
    }

    /**
     * Toggle resource status (active/inactive)
     */
    public function toggleStatus(LibraryResource $libraryResource)
    {
        $libraryResource->status = !$libraryResource->status;
        $libraryResource->save();

        return response()->json([
            'message' => 'Resource status updated successfully',
            'status' => $libraryResource->status
        ]);
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(LibraryResource $libraryResource)
    {
        $libraryResource->featured = !$libraryResource->featured;
        $libraryResource->save();

        return response()->json([
            'message' => 'Resource featured status updated successfully',
            'featured' => $libraryResource->featured
        ]);
    }

    /**
     * Update sort order
     */
    public function updateSortOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'resources' => 'required|array',
            'resources.*.id' => 'required|exists:library_resources,id',
            'resources.*.sort_order' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        foreach ($request->get('resources') as $resourceData) {
            $resource = LibraryResource::find($resourceData['id']);
            if ($resource) {
                $resource->sort_order = $resourceData['sort_order'];
                $resource->save();
            }
        }

        return response()->json([
            'message' => 'Sort order updated successfully'
        ]);
    }

    /**
     * Get public resources for frontend
     */
    public function getPublicResources()
    {
        $resources = LibraryResource::active()
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['resources' => $resources])
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
