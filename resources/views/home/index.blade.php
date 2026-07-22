@extends('layouts.app')
@section('title', 'Beranda')

@section('content')

@if($slides->count())
<section class="relative bg-slate-900 overflow-hidden" style="height: min(80vh, 620px)">
    <div id="headerSlider" class="relative w-full h-full cursor-pointer select-none">
        @foreach($slides as $i => $slide)
            <div class="header-slide absolute inset-0 {{ $i === 0 ? '' : 'hidden' }}" data-duration="{{ $slide->duration_seconds }}" data-title="{{ $slide->title ?: 'Slide '.($i+1) }}">
                @if($slide->media_type === 'video')
                    <video src="{{ asset('storage/'.$slide->file_path) }}" class="w-full h-full object-cover" muted playsinline></video>
                @else
                    <img src="{{ asset('storage/'.$slide->file_path) }}" class="w-full h-full object-cover">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/10 to-black/30"></div>
            </div>
        @endforeach
    </div>

    {{-- Label + progress, lebar tiap label sekarang SERAGAM (diatur di header-slider.js), gap dikecilin biar muat rapi --}}
    <div id="sliderLabels" class="absolute bottom-16 sm:bottom-20 left-0 right-0 flex justify-center gap-4 sm:gap-8 px-4 overflow-x-auto z-10"></div>
</section>
<script src="{{ asset('js/header-slider.js') }}"></script>
@else
<section class="bg-gradient-to-br from-primary-700 to-primary-900 text-white py-24 text-center pt-32">
    <h1 class="text-3xl sm:text-4xl font-bold">PERUMDAM Tirta Darma Ayu</h1>
    <p class="text-primary-100 mt-3">Air Bersih, Pelayanan Terpercaya untuk Kabupaten Indramayu</p>
</section>
@endif

@if($highlights->count())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
    <div class="bg-white rounded-2xl shadow-xl grid grid-cols-2 sm:grid-cols-{{ $highlights->count() }} divide-x divide-slate-100 overflow-hidden">
        @foreach($highlights as $h)
            <div class="p-6 text-center hover:bg-slate-50 transition">
                <div class="text-2xl sm:text-3xl font-bold text-primary-700">{{ $h->value }}</div>
                <div class="text-slate-500 text-xs sm:text-sm mt-1">{{ $h->label }}</div>
            </div>
        @endforeach
    </div>
</section>
@endif

{{-- Sekilas PDAM - ditaruh duluan sebelum card Tentang Kami --}}
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <h2 class="text-2xl sm:text-3xl font-bold mb-6">Sekilas PDAM</h2>
    <div class="prose max-w-none text-slate-600 leading-relaxed mx-auto">
        {!! nl2br(e(\Illuminate\Support\Str::limit(strip_tags($aboutUs->sekilas_text), 500))) ?: '<p class="text-slate-400 italic">Belum ada konten.</p>' !!}
    </div>
    <a href="{{ route('about-us.index') }}#sekilas" class="inline-flex items-center gap-1 text-primary-600 font-medium text-sm mt-4 hover:gap-2 transition-all">Selengkapnya →</a>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <h2 class="text-2xl font-bold mb-6">Tentang Kami</h2>
    <a href="{{ route('about-us.index') }}" class="group grid md:grid-cols-2 gap-0 bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all overflow-hidden border">
        <div class="aspect-square overflow-hidden">
            <img src="{{ $aboutUs->header_image ? asset('storage/'.$aboutUs->header_image) : 'https://placehold.co/800x800/1e3a8a/white?text=PDAM+TDA' }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        </div>
        <div class="p-8 flex flex-col justify-center">
            <span class="text-primary-600 font-semibold text-sm mb-2">Profil Perusahaan</span>
            <h3 class="text-xl font-bold mb-3">{{ $aboutUs->header_caption ?: 'Kenali PERUMDAM Tirta Darma Ayu Lebih Dekat' }}</h3>
            <p class="text-slate-500 text-sm line-clamp-3">{{ Str::limit(strip_tags($aboutUs->sekilas_text), 160) ?: 'Sejarah, visi misi, struktur organisasi, dan jajaran direksi perusahaan.' }}</p>
            <span class="inline-flex items-center gap-1 text-primary-600 font-medium text-sm mt-4 group-hover:gap-2 transition-all">Selengkapnya →</span>
        </div>
    </a>
</section>

<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold">Media &amp; Informasi</h2>
            <a href="{{ route('media-informasi.index') }}" class="text-primary-600 font-medium hover:underline text-sm">Lihat semua →</a>
        </div>

        <div class="grid grid-cols-1 gap-3 mb-8 sm:grid-cols-2">
            @forelse($latestAnnouncements->take(2) as $ann)
                <a href="{{ route('announcements.index') }}" class="bg-slate-50 hover:bg-primary-50 rounded-xl p-4 flex items-center gap-3 transition">
                    <span class="text-2xl">📢</span>
                    <div class="min-w-0">
                        <div class="text-xs text-primary-600 font-semibold">Pengumuman</div>
                        <div class="font-medium text-sm truncate">{{ $ann->title }}</div>
                    </div>
                </a>
            @empty
                <div class="bg-slate-50 rounded-xl p-4 text-sm text-slate-400 sm:col-span-2">Belum ada pengumuman.</div>
            @endforelse
        </div>

        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold">Perumdam TDA<span class="text-red-600">|</span>News</h3>
            <a href="{{ route('news.index') }}" class="text-primary-600 font-medium hover:underline text-sm">Selengkapnya →</a>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @forelse ($latestNews as $item)
                @include('partials.news-card', ['item' => $item])
            @empty
                <p class="text-slate-500 col-span-3">Belum ada berita.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid sm:grid-cols-3 gap-6 text-center">
    <a href="{{ route('procurement.index') }}" class="p-8 rounded-2xl border bg-white hover:border-primary-500 hover:shadow-lg hover:-translate-y-1 transition-all">
        <div class="text-4xl mb-3">📄</div>
        <div class="font-semibold">Pengadaan</div>
        <p class="text-sm text-slate-500 mt-1">Info pengadaan barang &amp; jasa</p>
    </a>
    <a href="{{ route('branches.index') }}" class="p-8 rounded-2xl border bg-white hover:border-primary-500 hover:shadow-lg hover:-translate-y-1 transition-all">
        <div class="text-4xl mb-3">📍</div>
        <div class="font-semibold">Hubungi Kami</div>
        <p class="text-sm text-slate-500 mt-1">Temukan cabang layanan terdekat</p>
    </a>
    <a href="{{ route('karir.index') }}" class="p-8 rounded-2xl border bg-white hover:border-primary-500 hover:shadow-lg hover:-translate-y-1 transition-all">
        <div class="text-4xl mb-3">💼</div>
        <div class="font-semibold">Karir</div>
        <p class="text-sm text-slate-500 mt-1">Bergabung bersama kami</p>
    </a>
</section>

<section class="bg-gradient-to-br from-primary-700 to-primary-900 py-14">
    <div class="max-w-4xl mx-auto px-4 text-center text-white">
        <h2 class="text-2xl font-bold mb-2">Kelola Layanan Air Lebih Mudah dengan Banyu Digital</h2>
        <p class="text-primary-100 mb-6">Cek tagihan, lapor pengaduan, dan pantau pemakaian air secara real-time.</p>
        <a href="{{ route('pengaduan-online.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-primary-700 font-semibold rounded-full hover:scale-105 hover:shadow-lg transition-all">
            📱 Unduh Banyu Digital
        </a>
    </div>
</section>

@endsection
