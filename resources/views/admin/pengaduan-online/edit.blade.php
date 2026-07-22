@extends('layouts.admin')
@section('title', 'Pengaduan Online')

@section('content')
<div class="max-w-2xl space-y-6">
    <form action="{{ route('admin.pengaduan-online.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border p-6 space-y-4">
        @csrf
        <h3 class="font-semibold">Header (foto blur di atas halaman)</h3>
        @if($content->header_image)
            <img src="{{ asset('storage/'.$content->header_image) }}" class="w-full h-40 object-cover rounded-lg">
        @endif
        <input type="file" name="header_image" accept="image/*" class="w-full text-sm">
        <input type="text" name="header_caption" value="{{ old('header_caption', $content->header_caption) }}" placeholder="Caption header (opsional)" class="w-full border rounded-lg px-3 py-2 text-sm">

        <h3 class="font-semibold pt-4 border-t">Poster Promosi (mis. Banyu Digital)</h3>
        @if($content->poster_image)
            <img src="{{ asset('storage/'.$content->poster_image) }}" class="w-full h-40 object-cover rounded-lg">
        @endif
        <input type="file" name="poster_image" accept="image/*" class="w-full text-sm">
        <p class="text-xs text-slate-400">Kalau belum diisi, halaman pakai desain default.</p>

        <button class="px-5 py-2 bg-primary-600 text-white rounded-lg text-sm">Simpan Semua</button>
    </form>
</div>
@endsection
