@extends('layouts.admin')
@section('title', 'Tambah Pengumuman')

@section('content')
<form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border p-6 max-w-2xl space-y-5">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-1">Judul</label>
        <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded-lg px-3 py-2 text-sm" required>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Deskripsi (opsional)</label>
        <textarea name="description" rows="4" class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('description') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Foto (opsional)</label>
        <input type="file" name="image" accept="image/*" class="w-full text-sm">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Dokumen PDF/Word (opsional)</label>
        <input type="file" name="document" accept=".pdf,.doc,.docx" class="w-full text-sm">
    </div>

    <div class="grid grid-cols-2 gap-3">
    <div>
        <label class="block text-sm font-medium mb-1">Mulai Tayang (opsional)</label>
        <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full border rounded-lg px-3 py-2 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Selesai Tayang (opsional)</label>
        <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full border rounded-lg px-3 py-2 text-sm">
    </div>
    </div>
    <p class="text-xs text-slate-400 -mt-2">Kosongkan kalau pengumuman mau tayang terus tanpa batas waktu.</p>

    <div class="flex gap-3">
        <button class="px-5 py-2 bg-primary-600 text-white rounded-lg text-sm">Simpan</button>
        <a href="{{ route('admin.announcements.index') }}" class="px-5 py-2 border rounded-lg text-sm">Batal</a>
    </div>
</form>
@endsection
