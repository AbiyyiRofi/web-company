@extends('layouts.app')
@section('title', 'Media & Informasi')

@section('content')

    @if($sliderNews->count())
        <section class="relative h-72 sm:h-96 bg-slate-900 overflow-hidden">
            <div id="newsHeaderSlider">
                @foreach($sliderNews as $i => $item)
                    @php
                        $imgUrl = $item->images->first() ? asset('storage/' . $item->images->first()->image_path) : ($item->cover_image ? asset('storage/' . $item->cover_image) : 'https://placehold.co/1600x600/1d4ed8/white?text=Perumdam+TDA+News');
                    @endphp
                    <div class="news-header-slide absolute inset-0 {{ $i === 0 ? '' : 'hidden' }}">
                        <img src="{{ $imgUrl }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-black/30"></div>
                        <div class="absolute inset-0 flex items-end">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 w-full">
                                @include('partials.breadcrumb', ['currentPage' => 'Media & Informasi'])
                                <span class="text-xs font-semibold text-red-400 uppercase">Perumdam TDA News</span>
                                <h1 class="text-2xl sm:text-3xl font-bold text-white mt-1 max-w-2xl">{{ $item->title }}</h1>
                                <a href="{{ route('news.show', $item->slug) }}"
                                    class="inline-flex items-center gap-1.5 mt-4 text-sm font-semibold px-4 py-2 rounded-full bg-white text-primary-700 hover:scale-105 transition-all">
                                    Selengkapnya →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($sliderNews->count() > 1)
                <button id="newsHeaderPrev"
                    class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center backdrop-blur transition z-10">‹</button>
                <button id="newsHeaderNext"
                    class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center backdrop-blur transition z-10">›</button>
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

        @php
            $featuredNews = $latestNews->first();
            $sideNews = $latestNews->slice(1, 5);
        @endphp

        <div class="flex items-center justify-between mb-6 reveal">
            <h2 class="text-2xl font-bold">Perumdam TDA<span class="text-primary-600">|</span>News</h2>
            <a href="{{ route('news.index') }}" class="text-primary-600 font-medium hover:underline text-sm">Selengkapnya
                →</a>
        </div>

        @if($featuredNews)
            @php
                $featuredImg = $featuredNews->images->first() ? asset('storage/' . $featuredNews->images->first()->image_path) : ($featuredNews->cover_image ? asset('storage/' . $featuredNews->cover_image) : 'https://placehold.co/900x600/2563eb/white?text=Perumdam+TDA');
            @endphp
            <div class="grid lg:grid-cols-5 gap-8 lg:gap-10 mb-16">
                {{-- BERITA UTAMA (kiri, besar) --}}
                <div class="lg:col-span-3 reveal">
                    <a href="{{ route('news.show', $featuredNews->slug) }}" class="group block">
                        <div class="rounded-2xl overflow-hidden h-64 sm:h-96 bg-slate-100">
                            <img src="{{ $featuredImg }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500" loading="lazy" decoding="async">
                        </div>
                        <span class="inline-block mt-4 text-xs font-bold text-primary-600 uppercase tracking-wide">Perumdam TDA
                            News</span>
                        <h3 class="text-xl sm:text-2xl font-bold mt-1 leading-snug group-hover:text-primary-700 transition">
                            {{ $featuredNews->title }}
                        </h3>
                        <p class="text-sm text-slate-400 mt-2">{{ $featuredNews->published_at?->translatedFormat('d F Y') }}</p>
                        <p class="text-slate-600 mt-3 line-clamp-3">
                            {{ str($featuredNews->content)->stripTags()->limit(180) }}
                        </p>
                        <span
                            class="inline-flex items-center gap-2 mt-5 px-6 py-2.5 border border-slate-300 rounded-full text-sm font-medium group-hover:bg-primary-600 group-hover:text-white group-hover:border-primary-600 transition">
                            Selengkapnya →
                        </span>
                    </a>
                </div>

                {{-- DAFTAR BERITA KECIL (kanan) --}}
                <div class="lg:col-span-2 divide-y divide-slate-100">
                    @foreach($sideNews as $item)
                        @php
                            $sideImg = $item->images->first() ? asset('storage/' . $item->images->first()->image_path) : ($item->cover_image ? asset('storage/' . $item->cover_image) : 'https://placehold.co/300x200/2563eb/white?text=TDA');
                        @endphp
                        <a href="{{ route('news.show', $item->slug) }}" class="group flex gap-3 py-4 first:pt-0 reveal">
                            <div class="w-20 h-16 sm:w-24 sm:h-20 shrink-0 rounded-lg overflow-hidden bg-slate-100">
                                <img src="{{ $sideImg }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500" loading="lazy" decoding="async">
                            </div>
                            <div class="min-w-0">
                                <span class="text-[11px] font-bold text-primary-600 uppercase tracking-wide">Perumdam TDA
                                    News</span>
                                <h4 class="text-sm font-semibold leading-snug line-clamp-2 group-hover:text-primary-700 transition">
                                    {{ $item->title }}
                                </h4>
                                <p class="text-xs text-slate-400 mt-1">{{ $item->published_at?->translatedFormat('d F Y') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <p class="text-slate-500 mb-16">Belum ada berita.</p>
        @endif

        <div class="flex items-center justify-between mb-6 reveal">
            <h2 class="text-2xl font-bold">Pengumuman Terbaru</h2>
            <a href="{{ route('announcements.index') }}"
                class="text-primary-600 font-medium hover:underline text-sm">Selengkapnya →</a>
        </div>
        <div class="bg-white rounded-2xl border divide-y mb-16 reveal">
            @forelse($latestAnnouncements as $ann)
                <a href="{{ route('announcements.index') }}" class="flex items-center gap-4 p-5 hover:bg-slate-50 transition">
                    @if($ann->image)
                        <img src="{{ asset('storage/' . $ann->image) }}" class="w-16 h-16 rounded-lg object-cover shrink-0" loading="lazy" decoding="async">
                    @else
                        <div class="w-16 h-16 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c.41 0 .789-.244.945-.623l.775-1.938a1.5 1.5 0 012.796.885v10.354a1.5 1.5 0 01-2.796.885l-.775-1.938a1.002 1.002 0 00-.945-.623H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                        </div>
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

        <div class="flex items-center justify-between mb-6 reveal">
            <h2 class="text-2xl font-bold">Galeri Terbaru</h2>
            <a href="{{ route('galleries.index') }}"
                class="text-primary-600 font-medium hover:underline text-sm">Selengkapnya →</a>
        </div>
        <div class="grid sm:grid-cols-3 gap-6 mb-16">
            @forelse($latestGalleries as $g)
                <a href="{{ route('galleries.show', $g) }}"
                    class="group block rounded-xl overflow-hidden border hover:shadow-lg transition-all relative h-48 reveal">
                    @if($g->photos->first() && !empty($g->photos->first()->image_path) && $g->photos->first()->image_path !== '0')
                        <img src="{{ asset('storage/' . $g->photos->first()->image_path) }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" decoding="async">
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

        {{-- CARD PUBLIKASI: teks-only, gaya sama seperti card Pengadaan di Beranda --}}
        <a href="{{ route('publications.index') }}"
            class="group flex flex-col md:flex-row md:items-center gap-4 md:gap-10 bg-white rounded-2xl border p-8 hover:shadow-xl transition-all reveal">
            <h3 class="text-2xl sm:text-3xl font-bold shrink-0 md:w-1/4 group-hover:text-primary-700 transition">
                Publikasi
            </h3>
            <p class="text-slate-500 flex-1">
                {{ $publikasiHeader->header_caption ?: 'Dokumen publik dan company profile Perumdam Tirta Darma Ayu.' }}
            </p>
            <span
                class="inline-flex items-center gap-2 shrink-0 px-6 py-2.5 border border-slate-300 rounded-full text-sm font-medium group-hover:bg-primary-600 group-hover:text-white group-hover:border-primary-600 transition">
                Selengkapnya →
            </span>
        </a>
    </section>
@endsection