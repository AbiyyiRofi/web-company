@extends('layouts.app')
@section('title', 'Perumdam TDA News')

@section('content')
<section class="relative h-64 sm:h-72 bg-slate-900 overflow-hidden">
    <img src="{{ $header->header_image ? asset('storage/'.$header->header_image) : 'https://placehold.co/1600x600/1d4ed8/white?text=Perumdam+TDA+News' }}" class="w-full h-full object-cover brightness-[0.45] blur-[1px]">
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 w-full" data-reveal-group>
            @include('partials.breadcrumb', ['currentPage' => 'Perumdam TDA News'])
            <h1 class="text-3xl sm:text-4xl font-bold text-white reveal">Perumdam TDA<span class="text-red-400">|</span>News</h1>
            @if($header->header_caption)
                <p class="text-primary-100 mt-2 max-w-2xl reveal">{{ $header->header_caption }}</p>
            @endif
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <form method="GET" class="mb-8 max-w-md mx-auto reveal">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita..."
               class="w-full border rounded-full px-5 py-3 text-sm shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
    </form>

    <div class="grid md:grid-cols-3 gap-6" data-reveal-group>
        @forelse ($news as $item)
            @include('partials.news-card', ['item' => $item])
        @empty
            <p class="text-slate-500 col-span-3 reveal">Belum ada berita.</p>
        @endforelse
    </div>

    <div class="mt-8 reveal">{{ $news->links() }}</div>
</section>
@endsection
