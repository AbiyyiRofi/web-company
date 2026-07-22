@extends('layouts.admin')
@section('title', 'Karir')

@section('content')
<div class="max-w-3xl space-y-6">

    {{-- FORM HEADER --}}
    <form action="{{ route('admin.karir.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border p-6 space-y-4">
        @csrf
        <h3 class="font-semibold">Header (foto blur di atas halaman)</h3>
        @if($content->header_image)
            <img src="{{ asset('storage/'.$content->header_image) }}" class="w-full h-40 object-cover rounded-lg">
        @endif
        <input type="file" name="header_image" accept="image/*" class="w-full text-sm">
        <input type="text" name="header_caption" value="{{ old('header_caption', $content->header_caption) }}" placeholder="Caption header (opsional)" class="w-full border rounded-lg px-3 py-2 text-sm">
        <button class="px-5 py-2 bg-primary-600 text-white rounded-lg text-sm">Simpan Header</button>
    </form>

    {{-- TAMBAH POSTER BARU --}}
    <form action="{{ route('admin.karir.posters.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border p-6 space-y-4">
        @csrf
        <h3 class="font-semibold">Tambah Poster Informasi Karir</h3>
        <input type="file" name="image" accept="image/*" required class="w-full text-sm">

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs text-slate-500 mb-1">Mulai Tayang (opsional)</label>
                <input type="date" name="start_date" class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs text-slate-500 mb-1">Selesai Tayang (opsional)</label>
                <input type="date" name="end_date" class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>
        </div>
        <p class="text-xs text-slate-400">Kosongkan tanggal kalau poster mau tayang terus tanpa batas waktu.</p>

        <button class="px-5 py-2 bg-primary-600 text-white rounded-lg text-sm">Upload Poster</button>
    </form>

    {{-- DAFTAR POSTER AKTIF/TERJADWAL --}}
    <div class="bg-white rounded-xl border p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold">Poster Saat Ini</h3>
            <a href="{{ route('admin.karir.history') }}" class="text-sm text-primary-600 hover:underline">Lihat Riwayat →</a>
        </div>

        <div class="space-y-3">
            @forelse($posters as $poster)
                <div class="flex items-center justify-between border rounded-lg p-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('storage/'.$poster->image) }}" class="w-16 h-16 object-cover rounded-lg">
                        <div class="text-sm">
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $poster->status === 'Aktif' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $poster->status === 'Terjadwal' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $poster->status === 'Kadaluarsa' ? 'bg-slate-200 text-slate-500' : '' }}">
                                {{ $poster->status }}
                            </span>
                            <div class="text-slate-500 mt-1">
                                {{ $poster->start_date?->format('d/m/Y') ?? 'Tanpa batas mulai' }}
                                —
                                {{ $poster->end_date?->format('d/m/Y') ?? 'Tanpa batas selesai' }}
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('admin.karir.posters.destroy', $poster) }}" method="POST" onsubmit="return confirm('Hapus poster ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline text-sm">Hapus</button>
                    </form>
                </div>
            @empty
                <p class="text-slate-400 text-center py-6">Belum ada poster. Halaman Karir akan menampilkan "COMING SOON".</p>
            @endforelse
        </div>
    </div>
</div>
@endsection