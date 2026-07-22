@extends('layouts.app')
@section('title', 'Media & Informasi')

@section('content')

@if($sliderNews->count())
<section class="relative h-72 sm:h-96 bg-slate-900 overflow-hidden">
    <div id="newsHeaderSlider">
        @foreach($sliderNews as $i => $item)
            <div class="news-header-slide absolute inset-0 {{ $i === 0 ? '' : 'hidden' }}">
                <img src="{{ $item->cover_image ? asset('storage/'.$item->cover_image) : 'https://placehold.co/1600x600/1d4ed8/white?text=Perumdam+TDA+News' }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-black/30"></div>
                <div class="absolute inset-0 flex items-end">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 w-full">
                        @include('partials.breadcrumb', ['currentPage' => 'Media & Informasi'])
                        <span class="text-xs font-semibold text-red-400 uppercase">Perumdam TDA News</span>
                        <h1 class="text-2xl sm:text-3xl font-bold text-white mt-1 max-w-2xl">{{ $item->title }}</h1>
                        <a href="{{ route('news.show', $item->slug) }}" class="inline-flex items-center gap-1.5 mt-4 text-sm font-semibold px-4 py-2 rounded-full bg-white text-primary-700 hover:scale-105 transition-all">
                            Selengkapnya →
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($sliderNews->count() > 1)
        <button id="newsHeaderPrev" class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center backdrop-blur transition z-10">‹</button>
        <button id="newsHeaderNext" class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center backdrop-blur transition z-10">›</button>
    @endif
</section>
<script src="{{ asset('js/news-header-slider.js') }}"></script>
@else
<section class="relative h-64 sm:h-72 bg-slate-900 overflow-hidden">
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 w-full">
            @include('partials.breadcrumb', ['currentPage' => 'Media & Informasi'])
            <h1 class="text-3xl sm:text-4xl font-bold text-white">Media &amp; Informasi</h1>
        </div>
    </div>
</section>
@endif

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="grid sm:grid-cols-3 gap-6 mb-16">
        <a href="{{ route('announcements.index') }}" class="p-6 rounded-2xl border bg-white hover:shadow-lg hover:-translate-y-1 transition-all">
            <div class="text-3xl mb-2">📢</div>
            <div class="font-semibold">Pengumuman</div>
            <p class="text-sm text-slate-500 mt-1">Info resmi &amp; regulasi terbaru</p>
        </a>
        <a href="{{ route('galleries.index') }}" class="p-6 rounded-2xl border bg-white hover:shadow-lg hover:-translate-y-1 transition-all">
            <div class="text-3xl mb-2">🖼️</div>
            <div class="font-semibold">Galeri</div>
            <p class="text-sm text-slate-500 mt-1">Dokumentasi kegiatan</p>
        </a>
        <a href="{{ route('publications.index') }}" class="p-6 rounded-2xl border bg-white hover:shadow-lg hover:-translate-y-1 transition-all">
            <div class="text-3xl mb-2">📚</div>
            <div class="font-semibold">Publikasi</div>
            <p class="text-sm text-slate-500 mt-1">Dokumen publik &amp; company profile</p>
        </a>
    </div>

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Perumdam TDA<span class="text-red-600">|</span>News</h2>
        <a href="{{ route('news.index') }}" class="text-primary-600 font-medium hover:underline text-sm">Selengkapnya →</a>
    </div>
    <div class="grid md:grid-cols-3 gap-6 mb-16">
        @forelse ($latestNews as $item)
            @include('partials.news-card', ['item' => $item])
        @empty
            <p class="text-slate-500 col-span-3">Belum ada berita.</p>
        @endforelse
    </div>

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Pengumuman Terbaru</h2>
        <a href="{{ route('announcements.index') }}" class="text-primary-600 font-medium hover:underline text-sm">Selengkapnya →</a>
    </div>
    <div class="bg-white rounded-2xl border divide-y mb-16">
        @forelse($latestAnnouncements as $ann)
            <a href="{{ route('announcements.index') }}" class="flex items-center gap-4 p-5 hover:bg-slate-50 transition">
                @if($ann->image)
                    <img src="{{ asset('storage/'.$ann->image) }}" class="w-16 h-16 rounded-lg object-cover shrink-0">
                @else
                    <div class="w-16 h-16 rounded-lg bg-primary-50 flex items-center justify-center text-2xl shrink-0">📢</div>
                @endif
                <div class="min-w-0">
                    <div class="font-medium truncate">{{ $ann->title }}</div>
                    <div class="text-xs text-slate-400 mt-1">{{ $ann->created_at->translatedFormat('d F Y') }}</div>
                </div>
            </a>
        @empty
            <p class="p-5 text-slate-400">Belum ada pengumuman.</p>
        @endforelse
    </div>

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Galeri Terbaru</h2>
        <a href="{{ route('galleries.index') }}" class="text-primary-600 font-medium hover:underline text-sm">Selengkapnya →</a>
    </div>
    <div class="grid sm:grid-cols-3 gap-6">
        @forelse($latestGalleries as $g)
            <a href="{{ route('galleries.show', $g) }}" class="group block rounded-xl overflow-hidden border hover:shadow-lg transition-all relative h-48">
                @if($g->photos->first())
                    <img src="{{ asset('storage/'.$g->photos->first()->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full bg-slate-100"></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-3 left-4 text-white">
                    <div class="font-semibold">{{ $g->title }}</div>
                    <div class="text-xs text-white/80">{{ $g->photos_count }} foto</div>
                </div>
            </a>
        @empty
            <p class="text-slate-400">Belum ada galeri.</p>
        @endforelse
    </div>
</section>
@endsection
