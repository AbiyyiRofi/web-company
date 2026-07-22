@extends('layouts.admin')
@section('title', 'Tambah Berita')

@section('content')
<form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border p-6 max-w-2xl space-y-5">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-1">Judul</label>
        <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded-lg px-3 py-2 text-sm" required>
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Foto (bisa tambah satu-satu)</label>
        <div id="imagePreviewGrid_images" class="grid grid-cols-4 gap-2 mb-2"></div>
        <input type="file" id="imagePicker_images" accept="image/*" multiple class="hidden">
        <input type="file" id="imagesInput_images" name="images[]" multiple class="hidden">
        <button type="button" data-add-image="images" class="text-sm px-4 py-2 border-2 border-dashed rounded-lg text-slate-500 hover:border-primary-400 hover:text-primary-600 transition w-full">+ Tambah Gambar</button>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Isi Berita</label>
        <textarea name="content" rows="8" class="w-full border rounded-lg px-3 py-2 text-sm" required>{{ old('content') }}</textarea>
    </div>

    <div class="flex gap-3">
        <button class="px-5 py-2 bg-primary-600 text-white rounded-lg text-sm">Simpan &amp; Tayangkan</button>
        <a href="{{ route('admin.news.index') }}" class="px-5 py-2 border rounded-lg text-sm">Batal</a>
    </div>
</form>

@push('scripts')
<script>document.addEventListener('DOMContentLoaded', () => initMultiImageUploader('images'));</script>
@endpush
@endsection
