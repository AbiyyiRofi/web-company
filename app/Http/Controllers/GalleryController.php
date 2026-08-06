<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\PageHeader;

class GalleryController extends Controller
{
    public function index()
    {
        $header = PageHeader::get('galeri');

        $categories = collect(Gallery::CATEGORIES)->map(function ($label, $slug) {
            $galleries = Gallery::withCount('photos')
                ->with(['photos' => fn ($q) => $q->orderBy('sort_order')])
                ->where('category', $slug)
                ->latest()
                ->get();

            return [
                'slug' => $slug,
                'label' => $label,
                'galleries' => $galleries,
                'covers' => $galleries->map(fn ($g) => optional($g->photos->first())->image_path)->filter()->values(),
            ];
        })->values();

        return view('galleries.index', compact('header', 'categories'));
    }

    public function show(Gallery $gallery)
    {
        $gallery->load('photos');
        return view('galleries.show', compact('gallery'));
    }
}