<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Highlight;
use Illuminate\Http\Request;

class HighlightController extends Controller
{
    public function index()
    {
        $highlights = Highlight::ordered();
        return view('admin.highlights.index', compact('highlights'));
    }

    public function store(Request $request)
    {
        if (Highlight::count() >= 4) {
            return back()->with('error', 'Maksimal 4 highlight. Hapus salah satu dulu buat nambah yang baru.');
        }

        $data = $request->validate([
            'value' => 'required|string|max:20',
            'label' => 'required|string|max:50',
        ]);

        $data['sort_order'] = Highlight::max('sort_order') + 1;

        Highlight::create($data);

        return back()->with('success', 'Highlight berhasil ditambahkan.');
    }

    public function update(Request $request, Highlight $highlight)
    {
        $data = $request->validate([
            'value' => 'required|string|max:20',
            'label' => 'required|string|max:50',
        ]);

        $highlight->update($data);

        return back()->with('success', 'Highlight berhasil diperbarui.');
    }

    public function destroy(Highlight $highlight)
    {
        $highlight->delete();
        return back()->with('success', 'Highlight berhasil dihapus.');
    }
}
