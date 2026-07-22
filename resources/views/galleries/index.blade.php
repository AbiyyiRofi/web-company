@extends('layouts.app')
@section('title', 'Galeri')

@section('content')
<section class="relative h-64 sm:h-72 bg-slate-900 overflow-hidden">
    <img src="{{ $header->header_image ? asset('storage/'.$header->header_image) : 'https://placehold.co/1600x600/1d4ed8/white?text=Galeri' }}" class="w-full h-full object-cover brightness-[0.45] blur-[1px]">
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 w-full">
            @include('partials.breadcrumb', ['currentPage' => 'Galeri'])
            <h1 class="text-3xl sm:text-4xl font-bold text-white">Galeri</h1>
            @if($header->header_caption)
                <p class="text-primary-100 mt-2 max-w-2xl">{{ $header->header_caption }}</p>
            @endif
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse ($galleries as $g)
            <a href="{{ route('galleries.show', $g) }}" class="group block rounded-xl overflow-hidden border hover:shadow-lg transition-all relative h-56">
                @if($g->photos->first())
                    <img src="{{ asset('storage/'.$g->photos->first()->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full bg-slate-100"></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white">
                    <div class="font-semibold">{{ $g->title }}</div>
                    <div class="text-xs text-white/80">{{ $g->photos_count }} foto</div>
                </div>
            </a>
        @empty
            <p class="text-slate-500 col-span-3">Belum ada galeri.</p>
        @endforelse
    </div>
    <div class="mt-8">{{ $galleries->links() }}</div>
</section>
@endsection
