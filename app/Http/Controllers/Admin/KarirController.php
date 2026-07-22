<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KarirContent;
use App\Models\KarirPoster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KarirController extends Controller
{
    public function edit()
    {
        $content = KarirContent::singleton();
        $posters = KarirPoster::latest()->get();
        return view('admin.karir.edit', compact('content', 'posters'));
    }

    public function update(Request $request)
    {
        $content = KarirContent::singleton();

        $data = $request->validate([
            'header_image' => 'nullable|image',
            'header_caption' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('header_image')) {
            if ($content->header_image) Storage::disk('public')->delete($content->header_image);
            $data['header_image'] = $request->file('header_image')->store('karir', 'public');
        }

        $content->update($data);

        return back()->with('success', 'Header Karir berhasil diperbarui.');
    }

    public function storePoster(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|image',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        KarirPoster::create([
            'image' => $request->file('image')->store('karir', 'public'),
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
        ]);

        return back()->with('success', 'Poster Karir berhasil ditambahkan.');
    }

    public function destroyPoster(KarirPoster $poster)
    {
        // Soft delete: file TIDAK dihapus, tersimpan sebagai bukti di halaman Riwayat
        $poster->delete();

        return back()->with('success', 'Poster Karir dihapus dan dipindahkan ke riwayat.');
    }

    public function history()
    {
        $posters = KarirPoster::withTrashed()->get()
            ->filter(fn ($p) => in_array($p->status, ['Dihapus', 'Kadaluarsa']))
            ->sortByDesc('created_at')
            ->values();

        return view('admin.karir.history', compact('posters'));
    }
}