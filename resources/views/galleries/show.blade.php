@extends('layouts.app')
@section('title', $gallery->title)

@section('content')
<section class="bg-slate-900 py-12 text-center" data-reveal-group>
    <h1 class="text-2xl sm:text-3xl font-bold text-white reveal">{{ $gallery->title }}</h1>
    <p class="text-slate-300 text-sm mt-1 reveal">{{ $gallery->photos->count() }} foto</p>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @php $allUrls = $gallery->photos->pluck('image_path')->map(fn($p)=>asset('storage/'.$p)); @endphp
    <div class="columns-2 sm:columns-3 gap-3 space-y-3" data-reveal-group>
        @forelse ($gallery->photos as $i => $photo)
            <img src="{{ asset('storage/'.$photo->image_path) }}"
                 onclick="openLightbox(@json($allUrls), {{ $i }})"
                 class="w-full rounded-lg cursor-pointer hover:opacity-90 transition break-inside-avoid reveal"
                 loading="lazy" decoding="async">
        @empty
            <p class="text-slate-500 reveal">Belum ada foto di album ini.</p>
        @endforelse
    </div>

    <a href="{{ route('galleries.index') }}" class="inline-block mt-10 text-primary-600 hover:underline reveal">← Kembali ke Galeri</a>
</section>
@endsection
