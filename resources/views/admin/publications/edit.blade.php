@extends('layouts.admin')
@section('title', 'Edit Dokumen')

@section('content')
<form action="{{ route('admin.publications.update', $document) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border p-6 max-w-xl space-y-5">
    @csrf @method('PUT')

    <div>
        <label class="block text-sm font-medium mb-1">Tipe</label>
        <select name="type" class="w-full border rounded-lg px-3 py-2 text-sm">
            <option value="dokumen_publik" @selected($document->type=='dokumen_publik')>Dokumen Publik</option>
            <option value="company_profile" @selected($document->type=='company_profile')>Company Profile</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Judul</label>
        <input type="text" name="title" value="{{ old('title', $document->title) }}" class="w-full border rounded-lg px-3 py-2 text-sm" required>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Kategori (opsional)</label>
        <input type="text" name="category" value="{{ old('category', $document->category) }}" class="w-full border rounded-lg px-3 py-2 text-sm">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">File saat ini: {{ strtoupper($document->file_type) }}</label>
        <p class="text-xs text-slate-400 mb-1">Upload file baru cuma kalau mau ganti, kosongkan kalau tetap.</p>
        <input type="file" name="file" accept=".pdf,.doc,.docx" class="w-full text-sm">
    </div>

    <div class="flex gap-3">
        <button class="px-5 py-2 bg-primary-600 text-white rounded-lg text-sm">Update</button>
        <a href="{{ route('admin.publications.index') }}" class="px-5 py-2 border rounded-lg text-sm">Batal</a>
    </div>
</form>
@endsection
