<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('images')->latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'images.*' => 'nullable|image',
        ]);

        $news = News::create([
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'slug' => Str::slug($data['title']) . '-' . Str::random(5),
            'content' => $data['content'],
            'published_at' => now(),
        ]);

        $this->storeImages($request, $news);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan dan langsung tayang.');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'images.*' => 'nullable|image',
            'remove_images' => 'nullable|array',
        ]);

        $news->update(['title' => $data['title'], 'content' => $data['content']]);

        if ($request->filled('remove_images')) {
            $images = $news->images()->whereIn('id', $request->remove_images)->get();
            foreach ($images as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
        }

        $this->storeImages($request, $news);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        foreach ($news->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }
        $news->delete();

        return back()->with('success', 'Berita berhasil dihapus.');
    }

    private function storeImages(Request $request, News $news): void
    {
        if (!$request->hasFile('images')) return;

        $order = $news->images()->max('sort_order') ?? 0;

        foreach ($request->file('images') as $file) {
            $order++;
            $path = $file->store('news', 'public');
            $news->images()->create(['image_path' => $path, 'sort_order' => $order]);

            if (!$news->cover_image) {
                $news->update(['cover_image' => $path]);
            }
        }
    }
}
