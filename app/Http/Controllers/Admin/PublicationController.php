<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicationController extends Controller
{
    public function index()
    {
        $dokumenPublik = Document::dokumenPublik()->latest()->get();
        $companyProfiles = Document::companyProfile()->latest()->get();

        return view('admin.publications.index', compact('dokumenPublik', 'companyProfiles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:dokumen_publik,company_profile',
            'category' => 'nullable|string|max:100',
            'file' => 'required|file|mimes:pdf,doc,docx',
        ]);

        $file = $request->file('file');

        Document::create([
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'type' => $data['type'],
            'category' => $data['category'] ?? null,
            'file_path' => $file->store('publications', 'public'),
            'file_type' => $file->getClientOriginalExtension(),
        ]);

        return back()->with('success', 'Dokumen berhasil diunggah.');
    }

    public function edit(Document $publication)
    {
        return view('admin.publications.edit', ['document' => $publication]);
    }

    public function update(Request $request, Document $publication)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:dokumen_publik,company_profile',
            'category' => 'nullable|string|max:100',
            'file' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $updateData = [
            'title' => $data['title'],
            'type' => $data['type'],
            'category' => $data['category'] ?? null,
        ];

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($publication->file_path);
            $file = $request->file('file');
            $updateData['file_path'] = $file->store('publications', 'public');
            $updateData['file_type'] = $file->getClientOriginalExtension();
        }

        $publication->update($updateData);

        return redirect()->route('admin.publications.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $publication)
    {
        Storage::disk('public')->delete($publication->file_path);
        $publication->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
