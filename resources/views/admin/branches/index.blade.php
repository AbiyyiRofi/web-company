@extends('layouts.admin')
@section('title', 'Kelola Cabang & IPA')

@section('content')
<div class="admin-card p-5 sm:p-6 mb-6">
    <h3 class="font-bold text-slate-800 mb-4">Header Halaman Hubungi Kami</h3>
    <form action="{{ route('admin.branches.header.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4 max-w-2xl">
        @csrf

        @include('partials.header-image-adjuster', [
            'content' => $content,
            'label' => 'Gambar Header Hubungi Kami',
            'pageTitle' => 'Hubungi Kami',
        ])

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Caption Header (opsional)</label>
            <input type="text" name="header_caption" value="{{ old('header_caption', $content->header_caption) }}" class="admin-input">
        </div>

        <div>
            <button class="btn-primary">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                Simpan Header Hubungi Kami
            </button>
        </div>
    </form>
</div>

<div class="flex items-center justify-between mb-5">
    <h3 class="font-bold text-slate-800">Cabang & Unit</h3>
    <a href="{{ route('admin.branches.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Tambah Lokasi
    </a>
</div>

<div class="table-wrapper mb-8 bg-white">
    <table class="admin-table" style="min-width: 600px;">
        <thead>
            <tr><th>Nama</th><th>Alamat</th><th>WhatsApp</th><th class="text-right">Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($branches as $b)
                <tr>
                    <td class="font-medium text-slate-800">
                        {{ $b->name }}
                        @if($b->is_head_office)
                            <span class="ml-1.5 text-[10px] bg-primary-50 text-primary-700 px-2 py-0.5 rounded-full font-semibold">Kantor Pusat</span>
                        @endif
                    </td>
                    <td class="text-slate-500">{{ $b->address }}</td>
                    <td class="text-slate-500 font-mono text-xs">{{ $b->whatsapp ?: '-' }}</td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('admin.branches.edit', $b) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-primary-50 transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                            </a>
                            <form action="{{ route('admin.branches.destroy', $b) }}" method="POST" class="inline" onsubmit="return confirm('Hapus lokasi ini?')">
                                @csrf @method('DELETE')
                                <button class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-slate-400 py-8">Belum ada cabang.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="flex items-center justify-between mb-5">
    <h3 class="font-bold text-slate-800">IPA (Instalasi Pengolahan Air)</h3>
</div>

<div class="table-wrapper bg-white">
    <table class="admin-table" style="min-width: 600px;">
        <thead>
            <tr><th>Nama</th><th>Alamat</th><th>Kapasitas Produksi</th><th class="text-right">Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($ipas as $ipa)
                <tr>
                    <td class="font-medium text-slate-800">{{ $ipa->name }}</td>
                    <td class="text-slate-500">{{ $ipa->address }}</td>
                    <td class="text-slate-500">{{ $ipa->kapasitas_produksi ?: '-' }}</td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('admin.branches.edit', $ipa) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-primary-50 transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                            </a>
                            <form action="{{ route('admin.branches.destroy', $ipa) }}" method="POST" class="inline" onsubmit="return confirm('Hapus IPA ini?')">
                                @csrf @method('DELETE')
                                <button class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-slate-400 py-8">Belum ada data IPA.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection