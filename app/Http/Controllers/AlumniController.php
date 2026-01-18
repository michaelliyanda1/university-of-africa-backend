<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\AlumniTestimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumni::approved()->ordered();

        if ($request->has('featured')) {
            $query->featured();
        }

        if ($request->has('limit')) {
            $alumni = $query->limit($request->get('limit'))->get();
        } else {
            $alumni = $query->paginate(20);
        }

        return response()->json([
            'data' => $alumni
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:alumnis',
            'phone' => 'nullable|string|max:20',
            'graduation_year' => 'required|integer|min:1950|max:' . date('Y'),
            'degree' => 'required|string|max:255',
            'current_position' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url|max:500',
            'bio' => 'nullable|string|max:2000',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('alumni', 'public');
            $validated['profile_image'] = $imagePath;
        }

        // Set default order
        $validated['order'] = Alumni::max('order') + 1;

        $alumni = Alumni::create($validated);

        return response()->json([
            'message' => 'Registration submitted successfully! Your profile will be reviewed and approved by the admin.',
            'alumni' => $alumni
        ], 201);
    }

    public function show(Alumni $alumni)
    {
        if (!$alumni->approved) {
            return response()->json(['error' => 'Alumni profile not found'], 404);
        }

        return response()->json([
            'alumni' => $alumni->load('approvedTestimonials')
        ]);
    }

    public function testimonials(Request $request)
    {
        $query = AlumniTestimonial::approved()->ordered();

        if ($request->has('limit')) {
            $testimonials = $query->limit($request->get('limit'))->get();
        } else {
            $testimonials = $query->paginate(20);
        }

        return response()->json([
            'data' => $testimonials
        ]);
    }

    public function storeTestimonial(Request $request)
    {
        $validated = $request->validate([
            'alumni_id' => 'required|exists:alumnis,id',
            'alumni_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'rating' => 'sometimes|integer|min:1|max:5'
        ]);

        // Set default rating
        $validated['rating'] = $validated['rating'] ?? 5;
        
        // Set default order
        $validated['order'] = AlumniTestimonial::max('order') + 1;

        $testimonial = AlumniTestimonial::create($validated);

        return response()->json([
            'message' => 'Testimonial submitted successfully! It will be reviewed and approved by the admin.',
            'testimonial' => $testimonial
        ], 201);
    }

    public function interactTestimonial(Request $request, AlumniTestimonial $testimonial)
    {
        $validated = $request->validate([
            'type' => 'required|in:like,comment',
            'action' => 'required|in:add,remove'
        ]);

        if ($validated['type'] === 'like') {
            if ($validated['action'] === 'add') {
                $testimonial->increment('likes');
            } else {
                $testimonial->decrement('likes');
            }
        } elseif ($validated['type'] === 'comment') {
            if ($validated['action'] === 'add') {
                $testimonial->increment('comments');
            } else {
                $testimonial->decrement('comments');
            }
        }

        return response()->json([
            'likes' => $testimonial->likes,
            'comments' => $testimonial->comments
        ]);
    }
}
