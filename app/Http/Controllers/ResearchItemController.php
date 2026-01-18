<?php

namespace App\Http\Controllers;

use App\Models\ResearchItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ResearchItemController extends Controller
{
    public function index(Request $request)
    {
        $query = ResearchItem::with(['collection.community.department', 'submitter'])
            ->approved();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('abstract', 'like', "%{$search}%")
                  ->orWhereJsonContains('keywords', $search);
            });
        }

        if ($request->has('collection_id')) {
            $query->where('collection_id', $request->collection_id);
        }

        if ($request->has('featured')) {
            $query->featured();
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        return response()->json($query->paginate(15));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'authors' => 'required|array',
            'authors.*' => 'required|string',
            'keywords' => 'nullable|array',
            'collection_id' => 'required|exists:collections,id',
            'file' => 'required|file|mimes:pdf|max:10240',
            'publication_date' => 'nullable|date',
            'doi' => 'nullable|string',
            'isbn' => 'nullable|string',
            'issn' => 'nullable|string',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . Str::slug($request->title) . '.pdf';
        $filePath = $file->storeAs('research', $fileName, 'public');

        $researchItem = ResearchItem::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'abstract' => $request->abstract,
            'authors' => $request->authors,
            'keywords' => $request->keywords,
            'collection_id' => $request->collection_id,
            'submitted_by' => $request->user()->id,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_size' => $file->getSize(),
            'file_type' => $file->getMimeType(),
            'publication_date' => $request->publication_date,
            'doi' => $request->doi,
            'isbn' => $request->isbn,
            'issn' => $request->issn,
            'status' => 'pending',
        ]);

        return response()->json($researchItem->load('collection'), 201);
    }

    public function show(ResearchItem $researchItem)
    {
        $researchItem->increment('view_count');
        
        return response()->json(
            $researchItem->load(['collection.community.department', 'submitter', 'approver'])
        );
    }

    public function download(ResearchItem $researchItem, Request $request)
    {
        $researchItem->increment('download_count');

        $researchItem->downloads()->create([
            'user_id' => $request->user()?->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return Storage::disk('public')->download($researchItem->file_path, $researchItem->file_name);
    }

    public function approve(ResearchItem $researchItem, Request $request)
    {
        $this->authorize('approve', $researchItem);

        $researchItem->update([
            'status' => 'approved',
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
        ]);

        return response()->json($researchItem);
    }

    public function reject(ResearchItem $researchItem, Request $request)
    {
        $this->authorize('approve', $researchItem);

        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $researchItem->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return response()->json($researchItem);
    }
}
