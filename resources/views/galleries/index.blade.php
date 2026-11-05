@extends('layouts.app')
@section('title', 'Galeri')

@section('content')
<section class="relative h-64 sm:h-72 bg-slate-900 overflow-hidden">
    <img src="{{ $header->header_image ? asset('storage/'.$header->header_image) : 'https://placehold.co/1600x600/1d4ed8/white?text=Galeri' }}" class="w-full h-full object-cover brightness-[0.45] blur-[1px]">
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 w-full" data-reveal-group>
            @include('partials.breadcrumb', ['currentPage' => 'Galeri'])
            <h1 class="text-3xl sm:text-4xl font-bold text-white reveal">Galeri</h1>
            @if($header->header_caption)
                <p class="text-primary-100 mt-2 max-w-2xl reveal">{{ $header->header_caption }}</p>
            @endif
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- ===== TAMPILAN 5 KATEGORI (default) ===== --}}
    <div id="galleryCategoryView">
        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6" data-reveal-group>
            @forelse($categories as $cat)
                @if($cat['galleries']->count())
                    <button type="button" onclick="openCategory('{{ $cat['slug'] }}')"
                            class="group relative block rounded-xl overflow-hidden border h-56 text-left reveal">
                        <div class="absolute inset-0" id="catCover-{{ $cat['slug'] }}">
                            @forelse($cat['covers'] as $i => $cover)
                                <img src="{{ asset('storage/'.$cover) }}"
                                     class="cat-cover-slide absolute inset-0 w-full h-full object-cover transition-opacity duration-700 {{ $i === 0 ? 'opacity-100' : 'opacity-0' }}"
                                     loading="lazy" decoding="async">
                            @empty
                                <div class="absolute inset-0 bg-slate-200"></div>
                            @endforelse
                        </div>
                        <div class="absolute inset-0 bg-black/40 group-hover:bg-black/50 transition"></div>
                        <div class="absolute inset-0 flex flex-col justify-end p-5">
                            <div class="flex items-end justify-between gap-2">
                                <div>
                                    <div class="font-bold text-white text-lg leading-snug">{{ $cat['label'] }}</div>
                                    <div class="text-xs text-white/70 mt-1">{{ $cat['galleries']->count() }} album</div>
                                </div>
                                <span class="w-10 h-10 rounded-full border border-white/40 flex items-center justify-center text-white group-hover:bg-white group-hover:text-slate-900 transition shrink-0">→</span>
                            </div>
                        </div>
                    </button>
                @endif
            @empty
                <p class="text-slate-500 col-span-3 reveal">Belum ada galeri.</p>
            @endforelse
        </div>
    </div>

    {{-- ===== TAMPILAN ALBUM PER KATEGORI (hidden default) ===== --}}
    @foreach($categories as $cat)
        <div id="galleryAlbumsView-{{ $cat['slug'] }}" class="hidden">
            <button type="button" onclick="closeCategory('{{ $cat['slug'] }}')" class="inline-flex items-center gap-1.5 text-primary-600 hover:underline text-sm mb-6">← Kembali ke Kategori</button>
            <h2 class="text-xl font-bold mb-6">{{ $cat['label'] }}</h2>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6" data-reveal-group>
                @foreach($cat['galleries'] as $g)
                    <button type="button" onclick="openAlbum({{ $g->id }})" class="group block text-left rounded-xl overflow-hidden border hover:shadow-lg transition-all relative h-56 reveal">
                        @if($g->photos->first())
                            <img src="{{ asset('storage/'.$g->photos->first()->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" decoding="async">
                        @else
                            <div class="w-full h-full bg-slate-100"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <div class="font-semibold">{{ $g->title }}</div>
                            <div class="text-xs text-white/80">{{ $g->photos_count }} foto</div>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    @endforeach

    {{-- ===== TAMPILAN FOTO ALBUM (hidden default) ===== --}}
    <div id="galleryPhotosView" class="hidden">
        <button type="button" onclick="closeAlbum()" class="inline-flex items-center gap-1.5 text-primary-600 hover:underline text-sm mb-6">← Kembali ke Album</button>
        <h2 id="galleryPhotosTitle" class="text-xl font-bold mb-1"></h2>
        <p id="galleryPhotosCount" class="text-xs text-slate-400 mb-6"></p>
        <div id="galleryPhotosGrid" class="columns-2 sm:columns-3 gap-3 space-y-3"></div>
    </div>

</section>

@push('scripts')
@php
    $galleriesForJs = $categories->flatMap(fn ($cat) => $cat['galleries'])->map(function ($g) {
        return [
            'id' => $g->id,
            'title' => $g->title,
            'photos' => $g->photos->map(fn ($p) => asset('storage/'.$p->image_path))->values(),
        ];
    })->values();
@endphp
<script>
    const galleriesData = @json($galleriesForJs);
    let currentCategorySlug = null;

    function openCategory(slug) {
        currentCategorySlug = slug;
        document.getElementById('galleryCategoryView').classList.add('hidden');
        document.getElementById('galleryAlbumsView-' + slug).classList.remove('hidden');
        window.scrollTo({ top: document.getElementById('galleryAlbumsView-' + slug).offsetTop - 100, behavior: 'smooth' });
    }

    function closeCategory(slug) {
        document.getElementById('galleryAlbumsView-' + slug).classList.add('hidden');
        document.getElementById('galleryCategoryView').classList.remove('hidden');
    }

    function openAlbum(id) {
        const g = galleriesData.find(x => x.id === id);
        if (!g) return;

        document.getElementById('galleryPhotosTitle').textContent = g.title;
        document.getElementById('galleryPhotosCount').textContent = g.photos.length + ' foto';

        const wrap = document.getElementById('galleryPhotosGrid');
        wrap.innerHTML = '';
        g.photos.forEach(function (url, i) {
            const img = document.createElement('img');
            img.src = url;
            img.loading = 'lazy';
            img.decoding = 'async';
            img.className = 'w-full rounded-lg cursor-pointer hover:opacity-90 transition break-inside-avoid';
            img.onclick = function () { openLightbox(g.photos, i); };
            wrap.appendChild(img);
        });

        document.getElementById('galleryAlbumsView-' + currentCategorySlug).classList.add('hidden');
        document.getElementById('galleryPhotosView').classList.remove('hidden');
        window.scrollTo({ top: document.getElementById('galleryPhotosView').offsetTop - 100, behavior: 'smooth' });
    }

    function closeAlbum() {
        document.getElementById('galleryPhotosView').classList.add('hidden');
        document.getElementById('galleryAlbumsView-' + currentCategorySlug).classList.remove('hidden');
    }

    // cover kategori auto-fade, sistem sama kayak kartu berita di Beranda
    document.querySelectorAll('[id^="catCover-"]').forEach(function (container) {
        const slides = container.querySelectorAll('.cat-cover-slide');
        if (slides.length <= 1) return;
        let i = 0;
        setInterval(function () {
            slides[i].classList.replace('opacity-100', 'opacity-0');
            i = (i + 1) % slides.length;
            slides[i].classList.replace('opacity-0', 'opacity-100');
        }, 4000);
    });
</script>
@endpush
@endsection