<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\News;

class MediaInformasiController extends Controller
{
    public function index()
    {
        // dipake buat slider header - seluruh berita yang pernah diupload, terbaru duluan
        $sliderNews = News::latest('published_at')->take(8)->get();

        $latestNews = News::latest('published_at')->take(6)->get();
        $latestAnnouncements = Announcement::latest()->take(3)->get();
        $latestGalleries = Gallery::withCount('photos')->latest()->take(3)->get();

        return view('media-informasi.index', compact('sliderNews', 'latestNews', 'latestAnnouncements', 'latestGalleries'));
    }
}
