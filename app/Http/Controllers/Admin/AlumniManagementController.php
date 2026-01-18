<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlumniManagementController extends Controller
{
    public function index()
    {
        $alumni = Alumni::orderBy('created_at', 'desc')->get();
        return response()->json($alumni);
    }

    public function stats()
    {
        $stats = [
            'total' => Alumni::count(),
            'approved' => Alumni::where('approved', true)->count(),
            'pending' => Alumni::where('approved', false)->count(),
            'featured' => Alumni::where('is_featured', true)->count()
        ];

        return response()->json($stats);
    }

    public function approve($id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->update([
            'approved' => true,
            'approved_at' => now()
        ]);

        return response()->json([
            'message' => 'Alumni approved successfully',
            'alumni' => $alumni
        ]);
    }

    public function reject($id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->update([
            'approved' => false,
            'approved_at' => null
        ]);

        return response()->json([
            'message' => 'Alumni registration rejected',
            'alumni' => $alumni
        ]);
    }

    public function toggleFeatured($id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->update([
            'is_featured' => !$alumni->is_featured
        ]);

        return response()->json([
            'message' => 'Featured status updated successfully',
            'alumni' => $alumni
        ]);
    }

    public function destroy($id)
    {
        $alumni = Alumni::findOrFail($id);
        
        // Delete profile image if exists
        if ($alumni->profile_image) {
            Storage::disk('public')->delete($alumni->profile_image);
        }
        
        $alumni->delete();

        return response()->json([
            'message' => 'Alumni deleted successfully'
        ]);
    }

    public function update(Request $request, $id)
    {
        $alumni = Alumni::findOrFail($id);
        
        \Log::info('Update request data:', [
            'all' => $request->all(),
            'files' => $request->allFiles(),
            'has_profile_image' => $request->hasFile('profile_image'),
            'has_reaction_image' => $request->hasFile('reaction_image')
        ]);
        
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255|unique:alumnis,email,' . $alumni->id,
            'phone' => 'nullable|string|max:20',
            'graduation_year' => 'sometimes|required|integer|min:1950|max:' . date('Y'),
            'degree' => 'sometimes|required|string|max:255',
            'current_position' => 'sometimes|required|string|max:255',
            'company' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url|max:500',
            'bio' => 'nullable|string|max:2000',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'reaction_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'is_featured' => 'sometimes|boolean',
            'approved' => 'sometimes|boolean',
            'order' => 'sometimes|integer'
        ]);

        \Log::info('Validated data:', $validated);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image
            if ($alumni->profile_image) {
                Storage::disk('public')->delete($alumni->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('alumni', 'public');
            \Log::info('Profile image stored:', ['path' => $validated['profile_image']]);
        }

        // Handle reaction image upload
        if ($request->hasFile('reaction_image')) {
            // Delete old reaction image
            if ($alumni->reaction_image) {
                Storage::disk('public')->delete($alumni->reaction_image);
            }
            $validated['reaction_image'] = $request->file('reaction_image')->store('alumni/reactions', 'public');
            \Log::info('Reaction image stored:', ['path' => $validated['reaction_image']]);
        }

        $alumni->update($validated);
        
        \Log::info('Alumni updated successfully:', ['alumni_id' => $alumni->id, 'reaction_image' => $alumni->reaction_image]);

        return response()->json([
            'message' => 'Alumni updated successfully',
            'alumni' => $alumni
        ]);
    }
}
