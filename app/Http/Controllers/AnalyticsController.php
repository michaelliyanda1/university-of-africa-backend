<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\ResearchItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();
        if (!$user || !$user->isStaff()) {
            abort(403);
        }

        $stats = [
            'total_research' => ResearchItem::count(),
            'approved_research' => ResearchItem::where('status', 'approved')->count(),
            'pending_research' => ResearchItem::where('status', 'pending')->count(),
            'total_downloads' => Download::count(),
            'total_users' => User::count(),
            'downloads_this_month' => Download::whereMonth('created_at', now()->month)->count(),
        ];

        $topDownloads = ResearchItem::approved()
            ->orderBy('download_count', 'desc')
            ->limit(10)
            ->get(['id', 'title', 'download_count', 'view_count']);

        $recentSubmissions = ResearchItem::with('submitter', 'collection')
            ->latest()
            ->limit(10)
            ->get();

        $downloadsByMonth = Download::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        return response()->json([
            'stats' => $stats,
            'top_downloads' => $topDownloads,
            'recent_submissions' => $recentSubmissions,
            'downloads_by_month' => $downloadsByMonth,
        ]);
    }
}
