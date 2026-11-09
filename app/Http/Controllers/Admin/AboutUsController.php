<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUsContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function edit()
    {
        $content = AboutUsContent::singleton();
        return view('admin.about-us.edit', compact('content'));
    }

    public function update(Request $request)
    {
        $content = AboutUsContent::singleton();

        $data = $request->validate([
            'header_image' => 'nullable|image',
            'header_caption' => 'nullable|string|max:255',
            'sekilas_text' => 'nullable|string',
            'harapan_text' => 'nullable|string',
            'harapan_photo' => 'nullable|image',
            'visi_text' => 'nullable|string',
            'misi_text' => 'nullable|string',
            'struktur_text' => 'nullable|string',
            'struktur_image' => 'nullable|image',
        ]);

        foreach (['header_image', 'harapan_photo', 'struktur_image'] as $field) {
            if ($request->hasFile($field)) {
                if ($content->$field) Storage::disk('public')->delete($content->$field);
                $data[$field] = $request->file($field)->store('about-us', 'public');
            } else {
                unset($data[$field]);
            }
        }

        $content->update($data);

        return back()->with('success', 'Konten Tentang Kami berhasil diperbarui.');
    }
}