<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\HubungiKamiContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::orderByDesc('is_head_office')->orderBy('name')->get();
        $content = HubungiKamiContent::singleton();

        return view('admin.branches.index', compact('branches', 'content'));
    }

    public function create()
    {
        return view('admin.branches.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'whatsapp' => 'nullable|string|max:30',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'operational_hours' => 'nullable|string|max:100',
            'is_head_office' => 'nullable|boolean',
        ]);

        $data['is_head_office'] = $request->boolean('is_head_office');
        $data['operational_hours'] = $data['operational_hours'] ?? 'Senin–Jumat, 07.30–16.00 WIB';

        Branch::create($data);

        return redirect()->route('admin.branches.index')->with('success', 'Cabang berhasil ditambahkan.');
    }

    public function edit(Branch $branch)
    {
        return view('admin.branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'whatsapp' => 'nullable|string|max:30',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'operational_hours' => 'nullable|string|max:100',
            'is_head_office' => 'nullable|boolean',
        ]);

        $data['is_head_office'] = $request->boolean('is_head_office');

        $branch->update($data);

        return redirect()->route('admin.branches.index')->with('success', 'Cabang berhasil diperbarui.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return back()->with('success', 'Cabang berhasil dihapus.');
    }

    // update header poster utk halaman Hubungi Kami
    public function updateHeader(Request $request)
    {
        $content = HubungiKamiContent::singleton();

        $data = $request->validate([
            'header_image' => 'nullable|image',
            'header_caption' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('header_image')) {
            if ($content->header_image) Storage::disk('public')->delete($content->header_image);
            $data['header_image'] = $request->file('header_image')->store('hubungi-kami', 'public');
        }

        $content->update($data);

        return back()->with('success', 'Header Hubungi Kami berhasil diperbarui.');
    }
}
