<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Branch;
use App\Models\Document;
use App\Models\Gallery;
use App\Models\News;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'news' => News::count(),
            'announcements' => Announcement::count(),
            'galleries' => Gallery::count(),
            'documents' => Document::count(),
            'branches' => Branch::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
