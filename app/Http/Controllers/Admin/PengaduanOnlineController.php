<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaduanOnlineContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaduanOnlineController extends Controller
{
    public function edit()
    {
        $content = PengaduanOnlineContent::singleton();
        return view('admin.pengaduan-online.edit', compact('content'));
    }

    public function update(Request $request)
    {
        $content = PengaduanOnlineContent::singleton();

        $data = $request->validate([
            'header_image' => 'nullable|image',
            'header_caption' => 'nullable|string|max:255',
            'poster_image' => 'nullable|image',
        ]);

        if ($request->hasFile('header_image')) {
            if ($content->header_image) Storage::disk('public')->delete($content->header_image);
            $data['header_image'] = $request->file('header_image')->store('pengaduan-online', 'public');
        }

        if ($request->hasFile('poster_image')) {
            if ($content->poster_image) Storage::disk('public')->delete($content->poster_image);
            $data['poster_image'] = $request->file('poster_image')->store('pengaduan-online', 'public');
        }

        $content->update($data);

        return back()->with('success', 'Konten Pengaduan Online berhasil diperbarui.');
    }
}
