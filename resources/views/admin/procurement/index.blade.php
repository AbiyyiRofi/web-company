@extends('layouts.admin')
@section('title', 'Pengadaan')

@section('content')
<div class="bg-white rounded-xl border p-6 mb-6">
    <h3 class="font-semibold mb-3">Header Halaman Pengadaan</h3>
    <form action="{{ route('admin.procurement.header.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4 max-w-2xl">
        @csrf

        @include('partials.header-image-adjuster', [
            'content' => $content,
            'label' => 'Gambar Header Pengadaan',
            'pageTitle' => 'Informasi Pengadaan',
        ])

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Caption Header (opsional)</label>
            <input type="text" name="header_caption" value="{{ old('header_caption', $content->header_caption) }}" placeholder="Caption header (opsional)" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500">
        </div>

        <div>
            <button class="px-5 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-semibold transition">
                Simpan Header Pengadaan
            </button>
        </div>
    </form>
</div>

<div class="flex justify-between items-center mb-6">
    <h3 class="font-semibold">Daftar Pengadaan</h3>
    <a href="{{ route('admin.procurement.history') }}" class="text-sm text-primary-600 hover:underline">Lihat Riwayat →</a>
    <a href="{{ route('admin.procurement.create') }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm">+ Tambah Pengadaan</a>
</div>

<div class="space-y-3">
    @forelse($procurements as $p)
        <div class="bg-white rounded-xl border p-5">
            <div class="flex items-start justify-between">
                <div>
                    <div class="font-semibold">{{ $p->title }}</div>
                    <div class="text-xs text-slate-400 mt-1">{{ $p->documents->count() }} dokumen · {{ $p->created_at->format('d/m/Y') }}</div>
                </div>
                <div class="flex gap-3 text-sm shrink-0">
                    <a href="{{ route('admin.procurement.edit', $p) }}" class="text-primary-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.procurement.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus pengadaan ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-slate-400 text-center py-8">Belum ada pengadaan. Klik "+ Tambah Pengadaan" buat bikin post baru.</p>
    @endforelse
</div>
@endsection
