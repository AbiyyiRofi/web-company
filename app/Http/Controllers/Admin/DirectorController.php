<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Director;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DirectorController extends Controller
{
    public function index()
    {
        $directors = Director::orderBy('type')->orderBy('sort_order')->get();
        return view('admin.about-us.directors', compact('directors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'photo' => 'nullable|image',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:direksi,pemilik_modal',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('directors', 'public');
        }

        $data['sort_order'] = Director::where('type', $data['type'])->max('sort_order') + 1;

        Director::create($data);

        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, Director $director)
    {
        $data = $request->validate([
            'photo' => 'nullable|image',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:direksi,pemilik_modal',
        ]);

        if ($request->hasFile('photo')) {
            if ($director->photo) Storage::disk('public')->delete($director->photo);
            $data['photo'] = $request->file('photo')->store('directors', 'public');
        }

        $director->update($data);

        return back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Director $director)
    {
        if ($director->photo) Storage::disk('public')->delete($director->photo);
        $director->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
