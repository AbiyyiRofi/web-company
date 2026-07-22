<?php

namespace App\Http\Controllers;

use App\Models\AboutUsContent;
use App\Models\Announcement;
use App\Models\Branch;
use App\Models\Highlight;
use App\Models\HomeHeaderSlide;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        $slides = HomeHeaderSlide::active()->get();
        $aboutUs = AboutUsContent::singleton();
        $highlights = Highlight::ordered();
        $latestNews = News::latest('published_at')->take(3)->get();
        $latestAnnouncements = Announcement::latest()->take(3)->get();
        $totalBranches = Branch::count();

        return view('home.index', compact(
            'slides', 'aboutUs', 'highlights', 'latestNews', 'latestAnnouncements', 'totalBranches'
        ));
    }
}
