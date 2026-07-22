@extends('layouts.app')
@section('title', 'Karir')

@section('content')
<section class="relative h-64 sm:h-72 bg-slate-900 overflow-hidden">
    <img src="{{ $content->header_image ? asset('storage/'.$content->header_image) : 'https://placehold.co/1600x600/1e3a8a/white?text=Karir' }}" class="w-full h-full object-cover brightness-[0.45] blur-[1px]">
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 w-full">
            @include('partials.breadcrumb', ['currentPage' => 'Karir'])
            <h1 class="text-3xl sm:text-4xl font-bold text-white">Karir</h1>
            @if($content->header_caption)
                <p class="text-primary-100 mt-2 max-w-2xl">{{ $content->header_caption }}</p>
            @endif
        </div>
    </div>
</section>

<section class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <h2 class="text-2xl font-bold mb-6">Pengumuman Penerimaan &amp; Pengembangan Karir</h2>
    <p class="text-slate-500 mb-8">Bergabunglah bersama PERUMDAM Tirta Darma Ayu dan jadi bagian dari upaya menghadirkan layanan air bersih terbaik untuk Kabupaten Indramayu.</p>
</section>

<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    {{-- TOMBOL DULU --}}
    <div class="text-center mb-8">
        <a href="http://karir.pdamindramayu.co.id/" target="_blank" rel="noopener"
           class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-primary-600 to-primary-400 text-white font-semibold rounded-full hover:scale-105 hover:shadow-xl transition-all">
            Klik Disini! →
        </a>
    </div>

    {{-- POSTER DI BAWAH TOMBOL --}}
    @if($poster)
        <img src="{{ asset('storage/'.$poster->image) }}" onclick="openLightbox(['{{ asset('storage/'.$poster->image) }}'], 0)"
             class="w-full rounded-2xl shadow-sm cursor-pointer hover:opacity-95 transition">
    @else
        <div class="bg-slate-100 border-2 border-dashed rounded-2xl p-16 text-center">
            <h3 class="text-2xl sm:text-3xl font-bold text-slate-400 mb-2">COMING SOON</h3>
            <p class="text-sm text-slate-400">Nantikan Informasi Mengenai Penerimaan dan Pengembangan Karir Mu Disini!</p>
        </div>
    @endif
</section>
@endsection