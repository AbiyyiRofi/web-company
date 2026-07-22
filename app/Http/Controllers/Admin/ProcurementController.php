<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Procurement;
use App\Models\ProcurementContent;
use App\Models\ProcurementDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProcurementController extends Controller
{
    public function index()
    {
        $content = ProcurementContent::singleton();
        $procurements = Procurement::with('documents')->latest()->get();

        return view('admin.procurement.index', compact('content', 'procurements'));
    }

    public function updateHeader(Request $request)
    {
        $content = ProcurementContent::singleton();

        $data = $request->validate([
            'header_image' => 'nullable|image',
            'header_caption' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('header_image')) {
            if ($content->header_image) Storage::disk('public')->delete($content->header_image);
            $data['header_image'] = $request->file('header_image')->store('procurement', 'public');
        }

        $content->update($data);

        return back()->with('success', 'Header Pengadaan berhasil diperbarui.');
    }

    public function create()
    {
        return view('admin.procurement.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'doc_titles.*' => 'nullable|string|max:255',
            'doc_files.*' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $procurement = Procurement::create([
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
        ]);

        $this->storeDocuments($request, $procurement);

        return redirect()->route('admin.procurement.index')->with('success', 'Pengadaan berhasil ditambahkan.');
    }

    public function edit(Procurement $procurement)
    {
        $procurement->load('documents');
        return view('admin.procurement.edit', compact('procurement'));
    }

    public function update(Request $request, Procurement $procurement)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'doc_titles.*' => 'nullable|string|max:255',
            'doc_files.*' => 'nullable|file|mimes:pdf,doc,docx',
            'remove_documents' => 'nullable|array',
        ]);

        $procurement->update(['title' => $data['title'], 'description' => $data['description'] ?? null]);

        if ($request->filled('remove_documents')) {
            $docs = $procurement->documents()->whereIn('id', $request->remove_documents)->get();
            foreach ($docs as $doc) {
                Storage::disk('public')->delete($doc->file_path);
                $doc->delete();
            }
        }

        $this->storeDocuments($request, $procurement);

        return redirect()->route('admin.procurement.index')->with('success', 'Pengadaan berhasil diperbarui.');
    }

    public function destroy(Procurement $procurement)
    {
        // Soft delete: dokumen TIDAK dihapus dari storage, tersimpan sebagai bukti di halaman Riwayat
        $procurement->delete();

        return back()->with('success', 'Pengadaan dihapus dan dipindahkan ke riwayat.');
    }

    private function storeDocuments(Request $request, Procurement $procurement): void
    {
        $titles = $request->input('doc_titles', []);
        $files = $request->file('doc_files', []);

        foreach ($files as $i => $file) {
            if (!$file) continue;
            $procurement->documents()->create([
                'title' => $titles[$i] ?? $file->getClientOriginalName(),
                'file_path' => $file->store('procurement', 'public'),
                'file_type' => $file->getClientOriginalExtension(),
            ]);
        }
    }
    public function history()
    {
        $procurements = Procurement::onlyTrashed()->with('documents')->latest()->get();
        return view('admin.procurement.history', compact('procurements'));
    }
}
