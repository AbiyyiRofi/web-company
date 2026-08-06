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
        $branches = Branch::cabang()->orderByDesc('is_head_office')->orderBy('name')->get();
        $ipas = Branch::ipa()->orderBy('name')->get();
        $content = HubungiKamiContent::singleton();

        return view('admin.branches.index', compact('branches', 'ipas', 'content'));
    }

    public function create()
    {
        return view('admin.branches.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['is_head_office'] = $request->boolean('is_head_office');
        $data['operational_hours'] = $data['operational_hours'] ?? 'Senin–Jumat, 07.30–16.00 WIB';

        Branch::create($data);

        return redirect()->route('admin.branches.index')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function edit(Branch $branch)
    {
        return view('admin.branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $data = $this->validateData($request);
        $data['is_head_office'] = $request->boolean('is_head_office');

        $branch->update($data);

        return redirect()->route('admin.branches.index')->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return back()->with('success', 'Lokasi berhasil dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'type' => 'required|in:cabang,ipa',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'whatsapp' => 'nullable|string|max:30',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'operational_hours' => 'nullable|string|max:100',
            'is_head_office' => 'nullable|boolean',
            'kapasitas_terpasang_text' => 'nullable|required_if:type,ipa|string',
            'kapasitas_produksi' => 'nullable|required_if:type,ipa|string|max:100',
            'idle_capacity' => 'nullable|required_if:type,ipa|string|max:100',
        ]);
    }

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