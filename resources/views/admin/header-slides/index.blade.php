@extends('layouts.admin')
@section('title', 'Poster Header Beranda')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-slate-500">{{ $slides->count() }}/5 poster digunakan</p>
    @if($slides->count() < 5)
        <a href="{{ route('admin.header-slides.create') }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm">+ Tambah Poster</a>
    @endif
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($slides as $slide)
        <div class="bg-white rounded-xl border overflow-hidden">
            <div class="h-40 bg-slate-100">
                @if($slide->media_type === 'video')
                    <video src="{{ asset('storage/'.$slide->file_path) }}" class="w-full h-full object-cover" muted></video>
                @else
                    <img src="{{ asset('storage/'.$slide->file_path) }}" class="w-full h-full object-cover">
                @endif
            </div>
            <div class="p-4">
                <div class="font-medium text-sm">{{ $slide->title ?: '(tanpa judul)' }}</div>
                <div class="text-xs text-slate-400 mt-1">{{ ucfirst($slide->media_type) }} - {{ $slide->duration_seconds }} detik</div>
                <div class="flex items-center justify-between mt-3">
                    <form action="{{ route('admin.header-slides.toggle', $slide) }}" method="POST">
                        @csrf
                        <button class="text-xs px-2 py-1 rounded-full {{ $slide->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ $slide->is_active ? 'Aktif' : 'Nonaktif' }}
                        </button>
                    </form>
                    <form action="{{ route('admin.header-slides.destroy', $slide) }}" method="POST" onsubmit="return confirm('Hapus poster ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 text-xs hover:underline">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-slate-400 col-span-3">Belum ada poster. Beranda akan menampilkan tampilan default.</p>
    @endforelse
</div>
@endsection
