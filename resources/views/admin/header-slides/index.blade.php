@extends('layouts.admin')
@section('title', 'Poster Header Beranda')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-lg font-bold text-slate-800">Poster & Video Header Beranda</h2>
        <p class="text-sm text-slate-500">{{ $slides->count() }}/5 poster digunakan (Maksimal 5 poster).</p>
    </div>
    @if($slides->count() < 5)
        <a href="{{ route('admin.header-slides.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Poster / Video
        </a>
    @endif
</div>

@if(session('success'))
    <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm flex items-center justify-between">
        <span>{{ session('success') }}</span>
    </div>
@endif
@if(session('error'))
    <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm flex items-center justify-between">
        <span>{{ session('error') }}</span>
    </div>
@endif

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @forelse($slides as $slide)
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col group">
            <div class="h-44 bg-slate-900 relative overflow-hidden">
                @if($slide->media_type === 'youtube')
                    @if($slide->youtube_thumbnail_url)
                        <img src="{{ $slide->youtube_thumbnail_url }}" alt="{{ $slide->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-slate-800 text-white">YouTube Video</div>
                    @endif
                    <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                        <div class="w-10 h-10 rounded-full bg-red-600 text-white flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5 fill-current ml-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </div>
                    </div>
                    <span class="absolute top-2.5 left-2.5 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-red-600 text-white shadow-sm flex items-center gap-1">
                        <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        YouTube
                    </span>
                @elseif($slide->media_type === 'video')
                    <video src="{{ asset('storage/'.$slide->file_path) }}" class="w-full h-full object-cover" muted></video>
                    <span class="absolute top-2.5 left-2.5 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-purple-600 text-white shadow-sm flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        Video File
                    </span>
                @else
                    <img src="{{ asset('storage/'.$slide->file_path) }}" alt="{{ $slide->title }}" class="w-full h-full object-cover">
                    <span class="absolute top-2.5 left-2.5 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-sky-600 text-white shadow-sm flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Foto
                    </span>
                @endif

                <span class="absolute bottom-2.5 right-2.5 px-2 py-0.5 rounded text-[11px] font-medium bg-black/70 text-white backdrop-blur-sm">
                    ⏱️ {{ $slide->duration_seconds }}s
                </span>
            </div>

            <div class="p-4 flex-1 flex flex-col justify-between">
                <div>
                    <h3 class="font-semibold text-sm text-slate-800 line-clamp-1">{{ $slide->title ?: '(Tanpa Judul)' }}</h3>
                    <div class="text-xs text-slate-400 mt-1 flex items-center gap-2">
                        @if($slide->media_type === 'youtube')
                            <span class="truncate max-w-[200px]" title="{{ $slide->youtube_url }}">{{ $slide->youtube_url }}</span>
                        @else
                            <span class="truncate max-w-[200px]" title="{{ $slide->file_path }}">{{ basename($slide->file_path) }}</span>
                        @endif
                    </div>
                </div>

                <div class="pt-4 mt-3 border-t border-slate-100 flex items-center justify-between">
                    <form action="{{ route('admin.header-slides.toggle', $slide) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs px-2.5 py-1 font-medium rounded-full transition {{ $slide->is_active ? 'bg-emerald-100 hover:bg-emerald-200 text-emerald-800' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
                            {{ $slide->is_active ? '● Aktif' : '○ Nonaktif' }}
                        </button>
                    </form>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.header-slides.edit', $slide) }}" class="text-xs font-medium text-primary-600 hover:text-primary-800 hover:underline">
                            Edit
                        </a>
                        <form action="{{ route('admin.header-slides.destroy', $slide) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus poster ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-medium text-red-600 hover:text-red-800 hover:underline">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white rounded-xl border border-dashed border-slate-300 p-12 text-center">
            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p class="text-slate-500 font-medium">Belum ada poster header.</p>
            <p class="text-xs text-slate-400 mt-1">Beranda akan menampilkan banner bawaan default.</p>
            <a href="{{ route('admin.header-slides.create') }}" class="inline-block mt-4 px-4 py-2 bg-primary-600 text-white rounded-lg text-xs font-medium">
                Tambah Poster Pertama
            </a>
        </div>
    @endforelse
</div>
@endsection
