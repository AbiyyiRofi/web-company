<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\PageHeader;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $header = PageHeader::get('news');

        $news = News::with('images')
            ->when($request->search, fn($q) => $q->where('title', 'like', '%' . $request->search . '%'))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('news.index', compact('header', 'news'));
    }

    public function show(string $slug)
    {
        $item = News::with('images')->where('slug', $slug)->firstOrFail();
        $related = News::where('id', '!=', $item->id)->latest('published_at')->take(3)->get();

        return view('news.show', compact('item', 'related'));
    }
}
