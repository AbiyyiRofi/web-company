@extends('layouts.admin')
@section('title', 'Galeri')

@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 grid sm:grid-cols-2 gap-4">
        @forelse($galleries as $g)
            <a href="{{ route('admin.galleries.show', $g) }}" class="bg-white rounded-xl border p-4 hover:shadow-md transition">
                <div class="font-semibold">{{ $g->title }}</div>
                <div class="text-xs text-slate-400 mt-1">{{ $g->photos_count }} foto</div>
            </a>
        @empty
            <p class="text-slate-400 col-span-2">Belum ada album.</p>
        @endforelse
    </div>
    <div>
        <div class="bg-white rounded-xl border p-6">
            <h3 class="font-semibold mb-3">Buat Album Baru</h3>
            <form action="{{ route('admin.galleries.store') }}" method="POST" class="space-y-3">
                @csrf
                <input type="text" name="title" placeholder="Judul album, mis. Upacara Hari Pegawai 2026" class="w-full border rounded-lg px-3 py-2 text-sm" required>
                <button class="w-full px-4 py-2 bg-primary-600 text-white rounded-lg text-sm">Buat Album</button>
            </form>
        </div>
    </div>
</div>
<div class="mt-6">{{ $galleries->links() }}</div>
@endsection
