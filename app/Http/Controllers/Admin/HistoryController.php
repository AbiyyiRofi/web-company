<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HistoryItem;
use App\Models\AboutUsContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = HistoryItem::orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();
        $content = AboutUsContent::singleton();
        return view('admin.history.index', compact('histories', 'content'));
    }

    public function updateBackground(Request $request)
    {
        $request->validate([
            'sejarah_bg_image' => 'nullable|image|max:5120',
            'remove_bg' => 'nullable|boolean',
        ]);

        $content = AboutUsContent::singleton();

        if ($request->boolean('remove_bg')) {
            if ($content->sejarah_bg_image) {
                Storage::disk('public')->delete($content->sejarah_bg_image);
                $content->update(['sejarah_bg_image' => null]);
            }
            return back()->with('success', 'Background Sejarah berhasil dihapus (menggunakan tema gelap standar).');
        }

        if ($request->hasFile('sejarah_bg_image')) {
            if ($content->sejarah_bg_image) {
                Storage::disk('public')->delete($content->sejarah_bg_image);
            }
            $path = $request->file('sejarah_bg_image')->store('about-us', 'public');
            $content->update(['sejarah_bg_image' => $path]);
            return back()->with('success', 'Background Sejarah berhasil diperbarui.');
        }

        return back();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|string|max:100',
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'sort_order' => 'nullable|integer',
        ]);

        if (empty($validated['sort_order'])) {
            $validated['sort_order'] = (HistoryItem::max('sort_order') ?? 0) + 1;
        }

        HistoryItem::create($validated);

        return back()->with('success', 'Data Sejarah berhasil ditambahkan.');
    }

    public function update(Request $request, HistoryItem $history)
    {
        $validated = $request->validate([
            'year' => 'required|string|max:100',
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'sort_order' => 'nullable|integer',
        ]);

        $history->update($validated);

        return back()->with('success', 'Data Sejarah berhasil diperbarui.');
    }

    public function destroy(HistoryItem $history)
    {
        $history->delete();
        return back()->with('success', 'Data Sejarah berhasil dihapus.');
    }
}
