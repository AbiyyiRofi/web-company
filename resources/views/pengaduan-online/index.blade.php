@extends('layouts.app')
@section('title', 'Pengaduan Online')

@section('content')
<section class="relative h-64 sm:h-72 bg-slate-900 overflow-hidden">
    <img src="{{ $content->header_image ? asset('storage/'.$content->header_image) : 'https://placehold.co/1600x600/1e3a8a/white?text=Pengaduan+Online' }}" class="w-full h-full object-cover brightness-[0.45] blur-[1px]">
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 w-full">
            @include('partials.breadcrumb', ['currentPage' => 'Pengaduan Online'])
            <h1 class="text-3xl sm:text-4xl font-bold text-white">Pengaduan Online</h1>
            @if($content->header_caption)
                <p class="text-primary-100 mt-2 max-w-2xl">{{ $content->header_caption }}</p>
            @endif
        </div>
    </div>
</section>

<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    @if($content->poster_image)
        <img src="{{ asset('storage/'.$content->poster_image) }}" class="w-full rounded-3xl">
    @else
        <div class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-blue-600 to-blue-400 p-10 sm:p-14 text-white">
            <div class="relative z-10 max-w-md">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-3xl">💧</span>
                    <div class="font-bold leading-tight">PERUMDA AIR MINUM<br>TIRTA DARMA AYU</div>
                </div>
                <p class="text-blue-100 mb-2">Kelola Layanan Air Lebih Mudah dengan</p>
                <h2 class="text-4xl font-bold mb-2">BANYU DIGITAL</h2>
                <p class="text-blue-100 mb-8">Cepat, Praktis, dan Terpercaya</p>
                <div class="grid grid-cols-3 gap-4 mb-4 text-center text-xs">
                    <div><div class="text-2xl mb-1">💧</div>Cek Tagihan</div>
                    <div><div class="text-2xl mb-1">📊</div>Pantau Pemakaian</div>
                    <div><div class="text-2xl mb-1">💬</div>Lapor &amp; Pengaduan</div>
                </div>
            </div>
        </div>
    @endif

    <div class="text-center mt-10">
        <a href="https://play.google.com/store/apps/details?id=com.pelayananperumdamtda.app&pcampaignid=web_share" target="_blank" rel="noopener"
           class="inline-flex items-center gap-3 px-8 py-4 bg-black text-white rounded-2xl hover:scale-105 hover:shadow-xl transition-all">
            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor"><path d="M3 20.5V3.5c0-.6.3-1.1.8-1.4l9.7 9.9-9.7 9.9c-.5-.3-.8-.8-.8-1.4zM16.9 9.7l-2.8-1.6L5.4 2.3l9.4 9.6 2.1-2.2zm-2.8 6.2l2.8-1.6-2.1-2.2-9.4 9.6 8.7-5.8zM20.2 10.8c.5.4.8.9.8 1.5s-.3 1.1-.8 1.5l-2.4 1.4-2.3-2.3v-1.2l2.3-2.3 2.4 1.4z"/></svg>
            <div class="text-left">
                <div class="text-xs">Dapatkan di</div>
                <div class="text-lg font-bold leading-tight">Google Play</div>
            </div>
        </a>
    </div>
</section>
@endsection
