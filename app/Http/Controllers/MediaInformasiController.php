<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\News;
use App\Models\PageHeader;

class MediaInformasiController extends Controller
{
    public function index()
    {
        // dipake buat slider header - seluruh berita yang pernah diupload, terbaru duluan
        $sliderNews = News::with('images')
            ->latest('published_at')
            ->take(8)
            ->get();

        $latestNews = News::with('images')
            ->latest('published_at')
            ->take(6)
            ->get();

        $latestAnnouncements = Announcement::active()->latest()->take(3)->get();
        $latestGalleries = Gallery::withCount('photos')->latest()->take(3)->get();
        $publikasiHeader = PageHeader::get('publikasi');

        return view('media-informasi.index', compact(
            'sliderNews', 'latestNews', 'latestAnnouncements', 'latestGalleries', 'publikasiHeader'
        ));
    }
}