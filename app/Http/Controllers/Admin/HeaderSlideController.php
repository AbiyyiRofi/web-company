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

        $mediaType = $request->input('media_type', 'image');

        $rules = [
            'title' => 'nullable|string|max:255',
            'media_type' => 'required|in:image,video,youtube',
            'duration_seconds' => 'required|integer|min:3|max:300',
        ];

        if ($mediaType === 'youtube') {
            $rules['youtube_url'] = 'required|string|max:500';
        } elseif ($mediaType === 'video') {
            $rules['file'] = 'required|file|mimes:mp4,mov,webm|max:102400';
        } else {
            $rules['file'] = 'required|file|mimes:jpg,jpeg,png,webp|max:10240';
        }

        $data = $request->validate($rules, [
            'youtube_url.required' => 'Link video YouTube wajib diisi jika memilih opsi YouTube.',
            'file.required' => 'File media wajib dipilih.',
            'file.mimes' => 'Format file tidak didukung.',
            'file.max' => 'Ukuran file melebihi batas maksimal server.',
        ]);

        $filePath = null;
        $youtubeUrl = null;
        $youtubeId = null;

        if ($mediaType === 'youtube') {
            $youtubeId = HomeHeaderSlide::extractYoutubeId($data['youtube_url']);
            if (!$youtubeId) {
                return back()->withInput()->withErrors([
                    'youtube_url' => 'Format link YouTube tidak valid. Contoh format: https://www.youtube.com/watch?v=... atau https://youtu.be/...',
                ]);
            }
            $youtubeUrl = $data['youtube_url'];
        } else {
            $filePath = $request->file('file')->store('header-slides', 'public');
        }

        HomeHeaderSlide::create([
            'title' => $data['title'] ?? null,
            'media_type' => $mediaType,
            'file_path' => $filePath,
            'youtube_url' => $youtubeUrl,
            'youtube_id' => $youtubeId,
            'duration_seconds' => $data['duration_seconds'],
            'sort_order' => (int) HomeHeaderSlide::max('sort_order') + 1,
        ]);

        return redirect()->route('admin.header-slides.index')->with('success', 'Poster header berhasil ditambahkan.');
    }

    public function edit(HomeHeaderSlide $slide)
    {
        return view('admin.header-slides.edit', compact('slide'));
    }

    public function update(Request $request, HomeHeaderSlide $slide)
    {
        $mediaType = $request->input('media_type', $slide->media_type);

        $rules = [
            'title' => 'nullable|string|max:255',
            'media_type' => 'required|in:image,video,youtube',
            'duration_seconds' => 'required|integer|min:3|max:300',
        ];

        if ($mediaType === 'youtube') {
            $rules['youtube_url'] = 'required|string|max:500';
        } elseif ($mediaType === 'video') {
            $rules['file'] = 'nullable|file|mimes:mp4,mov,webm|max:102400';
        } else {
            $rules['file'] = 'nullable|file|mimes:jpg,jpeg,png,webp|max:10240';
        }

        $data = $request->validate($rules, [
            'youtube_url.required' => 'Link video YouTube wajib diisi jika memilih opsi YouTube.',
            'file.mimes' => 'Format file tidak didukung.',
            'file.max' => 'Ukuran file melebihi batas maksimal server.',
        ]);

        $filePath = $slide->file_path;
        $youtubeUrl = $slide->youtube_url;
        $youtubeId = $slide->youtube_id;

        if ($mediaType === 'youtube') {
            $extractedId = HomeHeaderSlide::extractYoutubeId($data['youtube_url']);
            if (!$extractedId) {
                return back()->withInput()->withErrors([
                    'youtube_url' => 'Format link YouTube tidak valid. Contoh format: https://www.youtube.com/watch?v=... atau https://youtu.be/...',
                ]);
            }
            $youtubeId = $extractedId;
            $youtubeUrl = $data['youtube_url'];
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
                $filePath = null;
            }
        } else {
            if ($request->hasFile('file')) {
                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                $filePath = $request->file('file')->store('header-slides', 'public');
            } elseif (!$filePath && $slide->media_type === 'youtube') {
                return back()->withInput()->withErrors([
                    'file' => 'File wajib diunggah untuk tipe media ini.',
                ]);
            }
            $youtubeUrl = null;
            $youtubeId = null;
        }

        $slide->update([
            'title' => $data['title'] ?? null,
            'media_type' => $mediaType,
            'file_path' => $filePath,
            'youtube_url' => $youtubeUrl,
            'youtube_id' => $youtubeId,
            'duration_seconds' => $data['duration_seconds'],
        ]);

        return redirect()->route('admin.header-slides.index')->with('success', 'Poster header berhasil diperbarui.');
    }

    public function destroy(HomeHeaderSlide $slide)
    {
        if ($slide->file_path && Storage::disk('public')->exists($slide->file_path)) {
            Storage::disk('public')->delete($slide->file_path);
        }
        $slide->delete();

        return back()->with('success', 'Poster berhasil dihapus.');
    }

    public function toggle(HomeHeaderSlide $slide)
    {
        $slide->update(['is_active' => !$slide->is_active]);
        return back()->with('success', 'Status poster diperbarui.');
    }
}
