@extends('layouts.admin')
@section('title', 'Edit Pengumuman')

@section('content')
<form action="{{ route('admin.announcements.update', $announcement) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border p-6 max-w-2xl space-y-5">
    @csrf @method('PUT')

    <div>
        <label class="block text-sm font-medium mb-1">Judul</label>
        <input type="text" name="title" value="{{ old('title', $announcement->title) }}" class="w-full border rounded-lg px-3 py-2 text-sm" required>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Deskripsi</label>
        <textarea name="description" rows="4" class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('description', $announcement->description) }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Foto</label>
        @if($announcement->image)
            <div class="flex items-center gap-3 mb-2">
                <img src="{{ asset('storage/'.$announcement->image) }}" class="w-20 h-20 object-cover rounded-lg">
                <label class="text-xs text-red-600 flex items-center gap-1">
                    <input type="checkbox" name="remove_image" value="1"> Hapus foto ini
                </label>
            </div>
        @endif
        <input type="file" name="image" accept="image/*" class="w-full text-sm">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Dokumen PDF/Word</label>
        @if($announcement->document_path)
            <div class="flex items-center justify-between bg-slate-50 rounded-lg p-3 mb-2 text-sm">
                <span>📎 Dokumen saat ini ({{ strtoupper($announcement->document_type) }})</span>
                <label class="text-xs text-red-600 flex items-center gap-1">
                    <input type="checkbox" name="remove_document" value="1"> Hapus
                </label>
            </div>
        @endif
        <input type="file" name="document" accept=".pdf,.doc,.docx" class="w-full text-sm">
    </div>
    
        <div class="grid grid-cols-2 gap-3">
    <div>
        <label class="block text-sm font-medium mb-1">Mulai Tayang (opsional)</label>
        <input type="date" name="start_date" value="{{ old('start_date', $announcement->start_date?->format('Y-m-d') ?? '') }}" class="w-full border rounded-lg px-3 py-2 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Selesai Tayang (opsional)</label>
        <input type="date" name="end_date" value="{{ old('end_date', $announcement->end_date?->format('Y-m-d') ?? '') }}" class="w-full border rounded-lg px-3 py-2 text-sm">
    </div>
    </div>
    <p class="text-xs text-slate-400 -mt-2">Kosongkan kalau pengumuman mau tayang terus tanpa batas waktu.</p>


    <div class="flex gap-3">
        <button class="px-5 py-2 bg-primary-600 text-white rounded-lg text-sm">Update</button>
        <a href="{{ route('admin.announcements.index') }}" class="px-5 py-2 border rounded-lg text-sm">Batal</a>
    </div>
</form>
@endsection
