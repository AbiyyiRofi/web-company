@extends('layouts.admin')
@section('title', 'Header ' . $label)

@section('content')
<form action="{{ route('admin.page-headers.update', $key) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border p-6 max-w-xl space-y-4">
    @csrf
    @if($content->header_image)
        <img src="{{ asset('storage/'.$content->header_image) }}" class="w-full h-40 object-cover rounded-lg">
    @endif
    <div>
        <label class="block text-sm font-medium mb-1">Gambar Header {{ $label }}</label>
        <input type="file" name="header_image" accept="image/*" class="w-full text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Caption (opsional)</label>
        <input type="text" name="header_caption" value="{{ old('header_caption', $content->header_caption) }}" class="w-full border rounded-lg px-3 py-2 text-sm">
    </div>
    <button class="px-5 py-2 bg-primary-600 text-white rounded-lg text-sm">Simpan</button>
</form>
@endsection
