@extends('layouts.admin')
@section('title', $gallery->title)

@section('content')
<div class="mb-6 flex items-start justify-between gap-4">
    <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" class="flex items-center gap-2 flex-1">
        @csrf @method('PUT')
        <input type="text" name="title" value="{{ $gallery->title }}" class="border rounded-lg px-3 py-2 text-sm font-semibold flex-1 max-w-md">
        <button class="px-3 py-2 bg-primary-600 text-white rounded-lg text-sm">Simpan Nama</button>
    </form>
    <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Hapus album ini beserta semua fotonya?')">
        @csrf @method('DELETE')
        <button class="text-red-600 text-sm hover:underline whitespace-nowrap">Hapus Album</button>
    </form>
</div>
<p class="text-sm text-slate-400 mb-6">{{ $gallery->photos->count() }} foto</p>

<div class="bg-white rounded-xl border p-6 mb-6">
    <form action="{{ route('admin.galleries.photos.add', $gallery) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label class="block text-sm font-medium mb-2">Tambah Foto (bisa satu-satu, seperti upload medsos)</label>
        <div id="imagePreviewGrid_gallery" class="grid grid-cols-6 gap-2 mb-2"></div>
        <input type="file" id="imagePicker_gallery" accept="image/*" multiple class="hidden">
        <input type="file" id="imagesInput_gallery" name="photos[]" multiple class="hidden">
        <div class="flex gap-2">
            <button type="button" data-add-image="gallery" class="flex-1 text-sm px-4 py-2 border-2 border-dashed rounded-lg text-slate-500 hover:border-primary-400 hover:text-primary-600 transition">+ Tambah Foto</button>
            <button class="px-5 py-2 bg-primary-600 text-white rounded-lg text-sm">Unggah</button>
        </div>
    </form>
</div>

<div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
    @foreach($gallery->photos as $photo)
        <div class="relative group">
            <img src="{{ asset('storage/'.$photo->image_path) }}" class="w-full h-24 object-cover rounded-lg">
            <form action="{{ route('admin.galleries.photos.destroy', $photo) }}" method="POST" onsubmit="return confirm('Hapus foto ini?')" class="absolute top-1 right-1">
                @csrf @method('DELETE')
                <button class="bg-red-500 text-white rounded-full w-6 h-6 text-sm opacity-0 group-hover:opacity-100 transition">×</button>
            </form>
        </div>
    @endforeach
</div>

@push('scripts')
<script>document.addEventListener('DOMContentLoaded', () => initMultiImageUploader('gallery'));</script>
@endpush
@endsection
