<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageHeaderController extends Controller
{
    private array $allowedKeys = [
        'news' => 'Perumdam TDA News',
        'galeri' => 'Galeri',
        'pengumuman' => 'Pengumuman',
        'publikasi' => 'Publikasi',
    ];

    public function edit(string $key)
    {
        $this->ensureAllowed($key);
        $content = PageHeader::get($key);
        return view('admin.page-headers.edit', [
            'content' => $content,
            'key' => $key,
            'label' => $this->allowedKeys[$key],
        ]);
    }

    public function update(Request $request, string $key)
    {
        $this->ensureAllowed($key);
        $content = PageHeader::get($key);

        $data = $request->validate([
            'header_image' => 'nullable|image',
            'header_caption' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('header_image')) {
            if ($content->header_image) Storage::disk('public')->delete($content->header_image);
            $data['header_image'] = $request->file('header_image')->store('page-headers', 'public');
        }

        $content->update($data);

        return back()->with('success', 'Header ' . $this->allowedKeys[$key] . ' berhasil diperbarui.');
    }

    private function ensureAllowed(string $key): void
    {
        if (!array_key_exists($key, $this->allowedKeys)) {
            throw new NotFoundHttpException();
        }
    }
}
