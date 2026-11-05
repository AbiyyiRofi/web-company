<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Branch;
use App\Models\Document;
use App\Models\Gallery;
use App\Models\GalleryPhoto;
use App\Models\News;
use App\Models\Procurement;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'news'          => News::count(),
            'announcements' => Announcement::count(),
            'galleries'     => Gallery::count(),
            'documents'     => Document::count(),
            'branches'      => Branch::count(),
            'photos'        => GalleryPhoto::count(),
            'procurement'   => Procurement::count(),
        ];

        // Monthly content activity for last 6 months (for chart)
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyData[] = [
                'label' => $date->translatedFormat('M Y'),
                'news'  => News::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->count(),
                'announcements' => Announcement::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->count(),
            ];
        }

        // Recent 5 news for quick overview
        $recentNews = News::latest()->take(5)->get(['id', 'title', 'created_at']);

        // Branch type distribution
        $branchStats = [
            'cabang' => Branch::where('type', 'cabang')->count(),
            'ipa'    => Branch::where('type', 'ipa')->count(),
        ];

        return view('admin.dashboard', compact('stats', 'monthlyData', 'recentNews', 'branchStats'));
    }
}
