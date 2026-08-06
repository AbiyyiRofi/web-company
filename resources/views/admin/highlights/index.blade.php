@extends('layouts.admin')
@section('title', 'Highlight Beranda')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-3">
        @forelse($highlights as $h)
            <div class="bg-white rounded-xl border p-4 shadow-sm">
                <form action="{{ route('admin.highlights.update', $h) }}" method="POST" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    @csrf @method('PUT')
                    <input type="text" name="value" value="{{ $h->value }}" class="border rounded-lg px-3 py-2 text-sm w-full sm:w-32 focus:ring-2 focus:ring-primary-500" placeholder="120K+">
                    <input type="text" name="label" value="{{ $h->label }}" class="border rounded-lg px-3 py-2 text-sm w-full sm:flex-1 focus:ring-2 focus:ring-primary-500" placeholder="Pelanggan Aktif">
                    <button class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium transition shrink-0">Simpan</button>
                </form>
                <div class="mt-2 text-right">
                    <form action="{{ route('admin.highlights.destroy', $h) }}" method="POST" onsubmit="return confirm('Hapus highlight ini?')" class="inline">
                        @csrf @method('DELETE')
                        <button class="text-red-600 text-xs hover:underline">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-slate-400 text-center py-8 bg-white rounded-xl border">Belum ada highlight. Tambah lewat form di samping (maks 4).</p>
        @endforelse
    </div>

    <div>
        <div class="bg-white rounded-xl border p-6 shadow-sm">
            <h3 class="font-semibold mb-3 text-slate-800">Tambah Highlight ({{ $highlights->count() }}/4)</h3>
            @if($highlights->count() < 4)
                <form action="{{ route('admin.highlights.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="text" name="value" placeholder="Nilai, mis. 120K+" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500" required>
                    <input type="text" name="label" placeholder="Label, mis. Pelanggan Aktif" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500" required>
                    <button class="w-full px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium transition">Tambah</button>
                </form>
            @else
                <p class="text-sm text-slate-400">Sudah maksimal 4 highlight. Hapus salah satu dulu buat nambah yang baru.</p>
            @endif
        </div>
    </div>
</div>
@endsection
