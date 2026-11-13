@extends('layouts.app')
@section('title', 'Beranda')

@section('content')

    @if($slides->count())
        <section class="relative bg-slate-900 overflow-hidden" style="height: min(80vh, 620px)">
            <div id="headerSlider" class="relative w-full h-full cursor-pointer select-none">
                @foreach($slides as $i => $slide)
                    <div class="header-slide absolute inset-0 {{ $i === 0 ? '' : 'hidden' }}"
                        data-duration="{{ $slide->duration_seconds }}" data-title="{{ $slide->title ?: 'Slide ' . ($i + 1) }}">
                        @if($slide->media_type === 'video')
                            @if($slide->file_path && $slide->file_path !== '0')
                                <video src="{{ asset('storage/' . $slide->file_path) }}" class="w-full h-full object-cover" muted
                                    playsinline></video>
                            @endif
                        @else
                            @if($slide->file_path && $slide->file_path !== '0')
                                <img src="{{ asset('storage/' . $slide->file_path) }}" class="w-full h-full object-cover">
                            @endif
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/10 to-black/30"></div>
                    </div>
                @endforeach
            </div>

            <div id="sliderLabels"
                class="absolute bottom-16 sm:bottom-20 left-0 right-0 flex justify-center gap-4 sm:gap-8 px-4 overflow-x-auto z-10">
            </div>
        </section>
        <script src="{{ asset('js/header-slider.js') }}"></script>
    @else
        <section class="bg-gradient-to-br from-primary-700 to-primary-900 text-white py-24 text-center pt-32">
            <h1 class="text-3xl sm:text-4xl font-bold reveal">PERUMDAM Tirta Darma Ayu</h1>
            <p class="text-primary-100 mt-3 reveal">Air Bersih, Pelayanan Terpercaya untuk Kabupaten Indramayu</p>
        </section>
    @endif

    @if($highlights->count())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
            <div
                class="bg-white rounded-2xl shadow-xl grid grid-cols-2 sm:grid-cols-{{ $highlights->count() }} divide-x divide-slate-100 overflow-hidden reveal">
                @foreach($highlights as $h)
                    <div class="p-6 text-center hover:bg-slate-50 transition">
                        <div class="text-2xl sm:text-3xl font-bold text-primary-700">{{ $h->value }}</div>
                        <div class="text-slate-500 text-xs sm:text-sm mt-1">{{ $h->label }}</div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ============ HERO SEKILAS + AJAKAN (gaya v2) ============ --}}
    <section class="relative bg-primary-900 overflow-hidden">
        <svg class="absolute inset-0 w-full h-full" viewBox="0 0 1200 500" preserveAspectRatio="xMidYMid slice"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M0,120 C300,220 900,20 1200,140 L1200,0 L0,0 Z" fill="white" opacity="0.05" />
            <path d="M0,480 C350,380 850,520 1200,400 L1200,500 L0,500 Z" fill="white" opacity="0.06" />
            <path d="M0,300 C280,380 400,220 700,280 C900,320 1050,260 1200,300" stroke="white" stroke-width="2" fill="none"
                opacity="0.08" />
            <path d="M0,340 C280,420 400,260 700,320 C900,360 1050,300 1200,340" stroke="white" stroke-width="2" fill="none"
                opacity="0.06" />
        </svg>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
            <h1 class="text-3xl sm:text-5xl font-bold text-white max-w-2xl leading-tight reveal">
                Air bersih, pelayanan terpercaya untuk Indramayu.
            </h1>
            <p class="text-primary-100 mt-6 max-w-xl leading-relaxed reveal">
                {{ \Illuminate\Support\Str::limit(strip_tags($aboutUs->sekilas_text), 220) ?: 'Menghadirkan sarana air bersih dan pelayanan publik yang andal, transparan, dan berkelanjutan bagi seluruh masyarakat Kabupaten Indramayu.' }}
            </p>
            <div class="flex flex-wrap items-center gap-4 mt-10 reveal">
                <a href="{{ route('about-us.index') }}"
                    class="inline-flex items-center gap-2 px-7 py-3.5 bg-primary-600 hover:bg-primary-500 text-white font-semibold rounded-full transition-all hover:scale-105">
                    Kenali Kami →
                </a>
                <a href="https://play.google.com/store/apps/details?id=com.pelayananperumdamtda.app&pcampaignid=web_share"
                    target="_blank" rel="noopener"
                    class="inline-flex items-center gap-3 px-6 py-3 bg-white text-slate-800 rounded-2xl hover:scale-105 hover:shadow-xl transition-all">
                    <svg class="w-7 h-7 text-primary-700" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M3 20.5V3.5c0-.6.3-1.1.8-1.4l9.7 9.9-9.7 9.9c-.5-.3-.8-.8-.8-1.4zM16.9 9.7l-2.8-1.6L5.4 2.3l9.4 9.6 2.1-2.2zm-2.8 6.2l2.8-1.6-2.1-2.2-9.4 9.6 8.7-5.8zM20.2 10.8c.5.4.8.9.8 1.5s-.3 1.1-.8 1.5l-2.4 1.4-2.3-2.3v-1.2l2.3-2.3 2.4 1.4z" />
                    </svg>
                    <div class="text-left leading-tight">
                        <div class="text-[11px] text-slate-500">Dapatkan di</div>
                        <div class="text-base font-bold">Google Play</div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- ============ UCAPAN HARAPAN & TERIMA KASIH ============ --}}
    @if($aboutUs->harapan_text || $aboutUs->harapan_photo)
        <section>
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 grid md:grid-cols-2 gap-10 items-stretch">
                <div class="flex justify-center md:justify-start reveal">
                    @if($aboutUs->harapan_photo)
                        <img src="{{ asset('storage/' . $aboutUs->harapan_photo) }}" class="w-full h-full object-contain">
                    @endif
                </div>
                <div class="reveal flex flex-col justify-center">
                    <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-slate-900">Harapan dan Terima Kasih</h2>
                    <div class="prose max-w-none text-slate-600 leading-relaxed whitespace-pre-line">
                        {!! Str::inlineMarkdown(e($aboutUs->harapan_text)) !!}
                    </div>
                    @if($direkturUtama)
                        <div class="mt-6 pt-4 border-t border-slate-100">
                            <div class="font-bold text-slate-900 text-lg">{{ $direkturUtama->name }}</div>
                            <div class="text-slate-500 font-medium text-sm">{{ $direkturUtama->position }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- ============ PENGUMUMAN (carousel full-post) ============ --}}
    @if($latestAnnouncements->count())
        <section>
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="flex items-center justify-between mb-6 reveal">
                    <h2 class="text-2xl font-bold">Pengumuman</h2>
                    <a href="{{ route('announcements.index') }}"
                        class="text-primary-600 font-medium hover:underline text-sm">Lihat semua →</a>
                </div>
                <div class="reveal">
                    @include('partials.announcement-post-slider', ['announcements' => $latestAnnouncements, 'sliderId' => 'annHomeSlider'])
                </div>
            </div>
        </section>
    @endif

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <h2 class="text-2xl font-bold mb-6">Tentang Kami</h2>
        <a href="{{ route('about-us.index') }}"
            class="group grid md:grid-cols-2 gap-0 bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all overflow-hidden border reveal">
            <div class="aspect-square overflow-hidden">
                <img src="{{ $aboutUs->header_image ? asset('storage/' . $aboutUs->header_image) : 'https://placehold.co/800x800/1e3a8a/white?text=PDAM+TDA' }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>
            <div class="p-8 flex flex-col justify-center">
                <span class="text-primary-600 font-semibold text-sm mb-2">Profil Perusahaan</span>
                <h3 class="text-xl font-bold mb-3">
                    {{ $aboutUs->header_caption ?: 'Kenali PERUMDAM Tirta Darma Ayu Lebih Dekat' }}</h3>
                <p class="text-slate-500 text-sm line-clamp-3">
                    {{ Str::limit(strip_tags($aboutUs->sekilas_text), 160) ?: 'Sejarah, visi misi, struktur organisasi, dan jajaran direksi perusahaan.' }}
                </p>
                <span
                    class="inline-flex items-center gap-1 text-primary-600 font-medium text-sm mt-4 group-hover:gap-2 transition-all">Selengkapnya
                    →</span>
            </div>
        </a>
    </section>

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold">Media &amp; Informasi</h2>
                <a href="{{ route('media-informasi.index') }}"
                    class="text-primary-600 font-medium hover:underline text-sm">Lihat semua →</a>
            </div>

            <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                {{-- KARTU BERITA (fade otomatis) --}}
                <div id="homeNewsCard"
                    class="relative z-0 h-72 sm:h-96 rounded-lg overflow-hidden bg-slate-900 lg:w-2/5 shrink-0 reveal">
                    @forelse($latestNews as $i => $item)
                        @php
                            $homeImg = $item->images->first() ? asset('storage/' . $item->images->first()->image_path) : ($item->cover_image ? asset('storage/' . $item->cover_image) : 'https://placehold.co/900x700/1d4ed8/white?text=Perumdam+TDA');
                        @endphp
                        <a href="{{ route('news.show', $item->slug) }}"
                            class="home-news-slide absolute inset-0 transition-opacity duration-700 {{ $i === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none' }}">
                            <img src="{{ $homeImg }}"
                                class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6">
                                <span class="text-xs font-semibold text-red-400 uppercase">Perumdam TDA News</span>
                                <h3 class="text-lg sm:text-xl font-bold text-white mt-1 line-clamp-2">{{ $item->title }}</h3>
                                <span
                                    class="inline-flex items-center gap-1.5 mt-4 text-sm font-semibold px-4 py-2 rounded-full bg-white text-primary-700">
                                    Selengkapnya →
                                </span>
                            </div>
                        </a>
                    @empty
                        <div class="absolute inset-0 flex items-center justify-center text-slate-400 text-sm">Belum ada berita.
                        </div>
                    @endforelse
                </div>

                {{-- KARTU SUB-HALAMAN: Pengumuman, Galeri, Publikasi (geser di mobile, grid di desktop) --}}
                <div class="relative flex-1 z-10 lg:-ml-10">
                    @php
                        $mediaCards = [
                            ['title' => 'Pengumuman', 'caption' => $pengumumanHeader->header_caption, 'route' => route('announcements.index')],
                            ['title' => 'Galeri', 'caption' => $galeriHeader->header_caption, 'route' => route('galleries.index')],
                            ['title' => 'Publikasi', 'caption' => $publikasiHeader->header_caption, 'route' => route('publications.index')],
                        ];
                    @endphp

                    <div id="mediaCardsTrack"
                        class="flex sm:grid sm:grid-cols-3 gap-4 overflow-x-auto sm:overflow-visible snap-x snap-mandatory scroll-smooth no-scrollbar -mx-4 px-4 sm:mx-0 sm:px-0">
                        @foreach($mediaCards as $card)
                            <a href="{{ $card['route'] }}"
                                class="group shrink-0 w-[78%] sm:w-auto snap-center rounded-lg p-6 flex flex-col justify-between h-56 sm:h-72 bg-primary-800 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:bg-slate-50 hover:shadow-xl reveal">
                                <div>
                                    <h3 class="text-xl font-bold text-white transition-colors group-hover:text-slate-900">
                                        {{ $card['title'] }}
                                    </h3>
                                    <div class="w-8 h-0.5 mt-3 mb-4 bg-white transition-colors group-hover:bg-primary-600">
                                    </div>
                                    <p
                                        class="text-sm leading-relaxed line-clamp-4 text-primary-100 transition-colors group-hover:text-slate-500">
                                        {{ $card['caption'] ?: 'Informasi seputar ' . $card['title'] . ' Perumdam Tirta Darma Ayu.' }}
                                    </p>
                                </div>
                                <span
                                    class="self-end w-9 h-9 rounded-full flex items-center justify-center border border-white/40 text-white transition-all group-hover:bg-primary-800 group-hover:text-white group-hover:border-slate-300">
                                    ↗
                                </span>
                            </a>
                        @endforeach
                    </div>

                    <div class="flex sm:hidden justify-center gap-3 mt-4">
                        <button type="button" onclick="scrollMediaCards(-1)"
                            class="w-9 h-9 rounded-full bg-white shadow border flex items-center justify-center hover:bg-slate-50 transition">‹</button>
                        <button type="button" onclick="scrollMediaCards(1)"
                            class="w-9 h-9 rounded-full bg-white shadow border flex items-center justify-center hover:bg-slate-50 transition">›</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('js/home-news-card-slider.js') }}"></script>

    <script>
    function scrollMediaCards(dir) {
        const track = document.getElementById('mediaCardsTrack');
        const card = track.querySelector('a');
        if (!card) return;
        const width = card.offsetWidth + 16; // 16px = gap-4
        track.scrollBy({ left: dir * width, behavior: 'smooth' });
    }
</script>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-6">
        @foreach($quickLinks as $i => $link)
            @if($i === 0)
                {{-- CARD TEKS SAJA (khusus Pengadaan) --}}
                <a href="{{ $link['route'] }}"
                    class="group flex flex-col md:flex-row md:items-center gap-4 md:gap-10 bg-white rounded-2xl border p-8 hover:shadow-xl transition-all reveal">
                    <h3 class="text-2xl sm:text-3xl font-bold shrink-0 md:w-1/4 group-hover:text-primary-700 transition">
                        {{ $link['title'] }}
                    </h3>
                    <p class="text-slate-500 flex-1">
                        {{ $link['caption'] ?: 'Informasi seputar ' . $link['label'] . ' Perumdam Tirta Darma Ayu.' }}
                    </p>
                    <span
                        class="inline-flex items-center gap-2 shrink-0 px-6 py-2.5 border border-slate-300 rounded-full text-sm font-medium group-hover:bg-primary-600 group-hover:text-white group-hover:border-primary-600 transition">
                        Selengkapnya →
                    </span>
                </a>
            @else
                {{-- CARD FOTO + TEKS (Hubungi Kami & Karir) --}}
                <a href="{{ $link['route'] }}"
                    class="group flex flex-col {{ $i % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse' }} items-stretch bg-white rounded-2xl border overflow-hidden hover:shadow-xl transition-all reveal">
                    <div class="md:w-2/5 h-52 md:h-auto overflow-hidden">
                        <img src="{{ $link['image'] ? asset('storage/' . $link['image']) : 'https://placehold.co/800x600/2563eb/white?text=' . urlencode($link['label']) }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="flex-1 p-8 flex flex-col justify-center">
                        <span
                            class="text-xs font-semibold text-primary-600 uppercase tracking-wide mb-2">{{ $link['label'] }}</span>
                        <h3 class="text-xl sm:text-2xl font-bold mb-2 group-hover:text-primary-700 transition">{{ $link['title'] }}
                        </h3>
                        <p class="text-slate-500 line-clamp-2">
                            {{ $link['caption'] ?: 'Informasi seputar ' . $link['label'] . ' Perumdam Tirta Darma Ayu.' }}
                        </p>
                        <span
                            class="inline-flex items-center gap-1.5 mt-4 text-primary-600 font-medium text-sm group-hover:gap-2.5 transition-all">
                            Selengkapnya →
                        </span>
                    </div>
                </a>
            @endif
        @endforeach
    </section>

@endsection