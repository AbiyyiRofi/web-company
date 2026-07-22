<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\PageHeader;

class GalleryController extends Controller
{
    public function index()
    {
        $header = PageHeader::get('galeri');
        $galleries = Gallery::withCount('photos')->with(['photos' => fn($q) => $q->limit(1)])->latest()->paginate(9);
        return view('galleries.index', compact('header', 'galleries'));
    }

    public function show(Gallery $gallery)
    {
        $gallery->load('photos');
        return view('galleries.show', compact('gallery'));
    }
}
