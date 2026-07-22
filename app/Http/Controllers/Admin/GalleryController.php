<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::withCount('photos')->latest()->paginate(10);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['title' => 'required|string|max:255']);
        $gallery = Gallery::create(['user_id' => auth()->id(), 'title' => $data['title']]);

        return redirect()->route('admin.galleries.show', $gallery)->with('success', 'Album dibuat, sekarang tambahkan foto.');
    }

    public function show(Gallery $gallery)
    {
        $gallery->load('photos');
        return view('admin.galleries.show', compact('gallery'));
    }

    public function updateTitle(Request $request, Gallery $gallery)
    {
        $data = $request->validate(['title' => 'required|string|max:255']);
        $gallery->update($data);

        return back()->with('success', 'Nama album berhasil diperbarui.');
    }

    public function addPhotos(Request $request, Gallery $gallery)
    {
        $request->validate(['photos.*' => 'required|image']);

        $order = $gallery->photos()->max('sort_order') ?? 0;

        foreach ($request->file('photos', []) as $file) {
            $order++;
            $path = $file->store('galleries', 'public');
            $gallery->photos()->create(['image_path' => $path, 'sort_order' => $order]);
        }

        return back()->with('success', 'Foto berhasil ditambahkan.');
    }

    public function destroyPhoto(\App\Models\GalleryPhoto $photo)
    {
        Storage::disk('public')->delete($photo->image_path);
        $photo->delete();

        return back()->with('success', 'Foto dihapus.');
    }

    public function destroy(Gallery $gallery)
    {
        foreach ($gallery->photos as $photo) {
            Storage::disk('public')->delete($photo->image_path);
        }
        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Album berhasil dihapus.');
    }
}
