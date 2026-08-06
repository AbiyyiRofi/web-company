@extends('layouts.admin')
@section('title', 'Kelola Cabang & IPA')

@section('content')
<div class="bg-white rounded-xl border p-6 mb-6">
    <h3 class="font-semibold mb-3">Header Halaman Hubungi Kami</h3>
    <form action="{{ route('admin.branches.header.update') }}" method="POST" enctype="multipart/form-data" class="grid sm:grid-cols-2 gap-4 items-end">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Gambar Header</label>
            @if($content->header_image)
                <img src="{{ asset('storage/'.$content->header_image) }}" class="w-full h-24 object-cover rounded-lg mb-2">
            @endif
            <input type="file" name="header_image" accept="image/*" class="w-full text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Caption</label>
            <input type="text" name="header_caption" value="{{ old('header_caption', $content->header_caption) }}" class="w-full border rounded-lg px-3 py-2 text-sm mb-2">
            <button class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm">Simpan Header</button>
        </div>
    </form>
</div>

<div class="flex justify-end mb-6">
    <a href="{{ route('admin.branches.create') }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm">+ Tambah Lokasi</a>
</div>

<h3 class="font-semibold mb-3">Cabang &amp; Unit</h3>
<div class="bg-white rounded-xl border overflow-hidden mb-8">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left text-slate-500">
            <tr><th class="p-4">Nama</th><th class="p-4">Alamat</th><th class="p-4">WhatsApp</th><th class="p-4">Aksi</th></tr>
        </thead>
        <tbody class="divide-y">
            @forelse($branches as $b)
                <tr>
                    <td class="p-4 font-medium">{{ $b->name }} @if($b->is_head_office)<span class="ml-1 text-xs bg-primary-100 text-primary-700 px-2 py-0.5 rounded-full">Pusat</span>@endif</td>
                    <td class="p-4 text-slate-500">{{ $b->address }}</td>
                    <td class="p-4">{{ $b->whatsapp ?: '-' }}</td>
                    <td class="p-4 space-x-2">
                        <a href="{{ route('admin.branches.edit', $b) }}" class="text-primary-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.branches.destroy', $b) }}" method="POST" class="inline" onsubmit="return confirm('Hapus lokasi ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="p-4 text-center text-slate-400">Belum ada cabang.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<h3 class="font-semibold mb-3">IPA (Instalasi Pengolahan Air)</h3>
<div class="bg-white rounded-xl border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left text-slate-500">
            <tr><th class="p-4">Nama</th><th class="p-4">Alamat</th><th class="p-4">Kapasitas Produksi</th><th class="p-4">Aksi</th></tr>
        </thead>
        <tbody class="divide-y">
            @forelse($ipas as $ipa)
                <tr>
                    <td class="p-4 font-medium">{{ $ipa->name }}</td>
                    <td class="p-4 text-slate-500">{{ $ipa->address }}</td>
                    <td class="p-4">{{ $ipa->kapasitas_produksi ?: '-' }}</td>
                    <td class="p-4 space-x-2">
                        <a href="{{ route('admin.branches.edit', $ipa) }}" class="text-primary-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.branches.destroy', $ipa) }}" method="POST" class="inline" onsubmit="return confirm('Hapus IPA ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="p-4 text-center text-slate-400">Belum ada data IPA.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection