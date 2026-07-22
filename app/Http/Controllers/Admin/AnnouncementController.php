<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'document' => 'nullable|file|mimes:pdf,doc,docx',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $payload = [
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
        ];

        if ($request->hasFile('image')) {
            $payload['image'] = $request->file('image')->store('announcements', 'public');
        }
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $payload['document_path'] = $file->store('announcements', 'public');
            $payload['document_type'] = $file->getClientOriginalExtension();
        }

        Announcement::create($payload);

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'document' => 'nullable|file|mimes:pdf,doc,docx',
            'remove_image' => 'nullable|boolean',
            'remove_document' => 'nullable|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $payload = [
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
        ];

        if ($request->boolean('remove_image') && $announcement->image) {
            Storage::disk('public')->delete($announcement->image);
            $payload['image'] = null;
        }
        if ($request->hasFile('image')) {
            if ($announcement->image) Storage::disk('public')->delete($announcement->image);
            $payload['image'] = $request->file('image')->store('announcements', 'public');
        }

        if ($request->boolean('remove_document') && $announcement->document_path) {
            Storage::disk('public')->delete($announcement->document_path);
            $payload['document_path'] = null;
            $payload['document_type'] = null;
        }
        if ($request->hasFile('document')) {
            if ($announcement->document_path) Storage::disk('public')->delete($announcement->document_path);
            $file = $request->file('document');
            $payload['document_path'] = $file->store('announcements', 'public');
            $payload['document_type'] = $file->getClientOriginalExtension();
        }

        $announcement->update($payload);

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        // Soft delete: file TIDAK dihapus, tersimpan sebagai bukti di halaman Riwayat
        $announcement->delete();

        return back()->with('success', 'Pengumuman dihapus dan dipindahkan ke riwayat.');
    }

    public function history()
    {
        $announcements = Announcement::withTrashed()->get()
            ->filter(fn ($a) => in_array($a->status, ['Dihapus', 'Kadaluarsa']))
            ->sortByDesc('created_at')
            ->values();

        return view('admin.announcements.history', compact('announcements'));
    }
}