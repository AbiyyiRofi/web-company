<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HistoryItem;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = HistoryItem::orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();
        return view('admin.history.index', compact('histories'));
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
