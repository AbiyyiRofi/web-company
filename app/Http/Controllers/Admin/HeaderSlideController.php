<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeHeaderSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeaderSlideController extends Controller
{
    public function index()
    {
        $slides = HomeHeaderSlide::orderBy('sort_order')->get();
        return view('admin.header-slides.index', compact('slides'));
    }

    public function create()
    {
        if (HomeHeaderSlide::count() >= 5) {
            return redirect()->route('admin.header-slides.index')
                ->with('error', 'Maksimal 5 poster header. Hapus salah satu dulu buat nambah yang baru.');
        }
        return view('admin.header-slides.create');
    }

    public function store(Request $request)
    {
        if (HomeHeaderSlide::count() >= 5) {
            return back()->with('error', 'Maksimal 5 poster header.');
        }

        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'media_type' => 'required|in:image,video',
            'file' => 'required|file|mimes:jpg,jpeg,png,webp,mp4,mov,webm',
            'duration_seconds' => 'required|integer|min:3|max:60',
        ]);

        $path = $request->file('file')->store('header-slides', 'public');

        HomeHeaderSlide::create([
            'title' => $data['title'] ?? null,
            'media_type' => $data['media_type'],
            'file_path' => $path,
            'duration_seconds' => $data['duration_seconds'],
            'sort_order' => HomeHeaderSlide::max('sort_order') + 1,
        ]);

        return redirect()->route('admin.header-slides.index')->with('success', 'Poster berhasil ditambahkan.');
    }

    public function destroy(HomeHeaderSlide $slide)
    {
        Storage::disk('public')->delete($slide->file_path);
        $slide->delete();

        return back()->with('success', 'Poster berhasil dihapus.');
    }

    public function toggle(HomeHeaderSlide $slide)
    {
        $slide->update(['is_active' => !$slide->is_active]);
        return back()->with('success', 'Status poster diperbarui.');
    }
}
