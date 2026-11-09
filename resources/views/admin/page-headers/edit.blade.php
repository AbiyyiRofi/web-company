@extends('layouts.admin')
@section('title', 'Header ' . $label)

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('admin.page-headers.update', $key) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border p-6 space-y-5">
        @csrf

        @include('partials.header-image-adjuster', [
            'content' => $content,
            'label' => 'Gambar Header ' . $label,
            'pageTitle' => $label,
        ])

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Caption (opsional)</label>
            <input type="text" name="header_caption" value="{{ old('header_caption', $content->header_caption) }}" placeholder="Tulis caption header jika ada..." class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500">
        </div>

        <div class="pt-2">
            <button class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                Simpan Header {{ $label }}
            </button>
        </div>
    </form>
</div>
@endsection
