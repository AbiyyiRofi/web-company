@extends('layouts.admin')
@section('title', 'Highlight Beranda')

@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-3">
        @forelse($highlights as $h)
            <form action="{{ route('admin.highlights.update', $h) }}" method="POST" class="bg-white rounded-xl border p-4 flex items-center gap-3">
                @csrf @method('PUT')
                <input type="text" name="value" value="{{ $h->value }}" class="border rounded-lg px-3 py-2 text-sm w-32" placeholder="120K+">
                <input type="text" name="label" value="{{ $h->label }}" class="border rounded-lg px-3 py-2 text-sm flex-1" placeholder="Pelanggan Aktif">
                <button class="px-3 py-2 bg-primary-600 text-white rounded-lg text-sm">Simpan</button>
            </form>
            <form action="{{ route('admin.highlights.destroy', $h) }}" method="POST" onsubmit="return confirm('Hapus highlight ini?')" class="-mt-2 mb-2 text-right">
                @csrf @method('DELETE')
                <button class="text-red-600 text-xs hover:underline">Hapus</button>
            </form>
        @empty
            <p class="text-slate-400 text-center py-8">Belum ada highlight. Tambah lewat form di samping (maks 4).</p>
        @endforelse
    </div>

    <div>
        <div class="bg-white rounded-xl border p-6">
            <h3 class="font-semibold mb-3">Tambah Highlight ({{ $highlights->count() }}/4)</h3>
            @if($highlights->count() < 4)
                <form action="{{ route('admin.highlights.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="text" name="value" placeholder="Nilai, mis. 120K+" class="w-full border rounded-lg px-3 py-2 text-sm" required>
                    <input type="text" name="label" placeholder="Label, mis. Pelanggan Aktif" class="w-full border rounded-lg px-3 py-2 text-sm" required>
                    <button class="w-full px-4 py-2 bg-primary-600 text-white rounded-lg text-sm">Tambah</button>
                </form>
            @else
                <p class="text-sm text-slate-400">Sudah maksimal 4 highlight. Hapus salah satu dulu buat nambah yang baru.</p>
            @endif
        </div>
    </div>
</div>
@endsection
