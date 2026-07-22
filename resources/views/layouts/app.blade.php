<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PERUMDAM Tirta Darma Ayu')</title>
    <meta name="description" content="Website resmi PERUMDAM Tirta Darma Ayu Kabupaten Indramayu">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: {
                primary: { 50:'#eff6ff',100:'#dbeafe',400:'#60a5fa',500:'#3b82f6',600:'#1d4ed8',700:'#1e40af',800:'#1e3a8a',900:'#172554' }
            } } }
        }
    </script>
    <style>
        .fade-img { transition: opacity 0.2s ease; }
        .nav-dropdown { transition: opacity .18s ease, transform .18s ease; }

        #mainHeader {
            position: fixed; top: 0; left: 0; right: 0; z-index: 50;
            background: transparent;
            transition: background-color .25s ease, box-shadow .25s ease, backdrop-filter .25s ease;
        }
        #mainHeader.nav-scrolled { background: rgba(255,255,255,0.97); backdrop-filter: blur(6px); box-shadow: 0 1px 8px rgba(0,0,0,0.08); }
        #mainHeader .mobile-icon { color: #ffffff; }
        #mainHeader.nav-scrolled .mobile-icon { color: #1e293b; }

        /* Search dropdown - posisinya ABSOLUTE, gak dorong elemen lain di flow */
        .search-dropdown { position: absolute; top: 100%; right: 0; margin-top: .5rem; z-index: 60; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
    @include('partials.loading-screen')

@php $siteLogo = \App\Models\SiteSetting::singleton(); @endphp

<header id="mainHeader">

    {{-- ===== MOBILE BAR (selalu tampil di layar kecil, gak pernah campur sama versi desktop) ===== --}}
    <div class="lg:hidden flex items-center justify-between h-[70px] px-4">
        <a href="{{ route('home') }}" class="flex items-center">
            @if($siteLogo->logo)
                <img src="{{ asset('storage/'.$siteLogo->logo) }}" class="h-11 w-auto object-contain">
            @else
                <span class="text-3xl">💧</span>
            @endif
        </a>
        <button id="mobileMenuBtn" class="mobile-icon w-10 h-10 flex items-center justify-center rounded-lg hover:bg-black/5">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>

    {{-- ===== WRAPPER DESKTOP (statis "hidden lg:block", gak pernah disentuh JS) ===== --}}
    <div class="hidden lg:block">

        {{-- ---- MODE REGULAR (non-scrolled) - JS yang toggle 'hidden' di sini ---- --}}
        <div id="navRegular">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 flex items-center justify-end gap-1 h-8 text-xs text-white">
                <a href="{{ route('procurement.index') }}" class="px-3 py-1 rounded hover:bg-white/10 transition">Pengadaan</a>
                <a href="{{ route('karir.index') }}" class="px-3 py-1 rounded hover:bg-white/10 transition">Karir</a>
                <div class="relative">
                    <button type="button" onclick="toggleSearch('Regular')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/10 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                    </button>
                    <div id="searchBoxRegular" class="search-dropdown hidden">
                        <form method="GET" action="{{ route('news.index') }}">
                            <input type="text" name="search" placeholder="Cari di Perumdam TDA News..." class="w-64 px-3 py-2 rounded-lg text-sm text-slate-800 shadow-xl border-0 focus:ring-2 focus:ring-primary-400">
                        </form>
                    </div>
                </div>
                <a href="{{ route('pengaduan-online.index') }}" class="ml-2 inline-flex items-center gap-1 text-xs font-semibold px-3 py-1.5 rounded-full bg-primary-600 text-white hover:bg-primary-700 hover:scale-105 transition-all">📢 Pengaduan Online</a>
                <a href="https://pelayananperumdamtda.com/mitra/bayar" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-xs font-semibold px-3 py-1.5 rounded-full bg-emerald-500 text-white hover:bg-emerald-600 hover:scale-105 transition-all">💳 Cek Tagihan</a>
            </div>

            <div class="max-w-7xl mx-auto px-6 lg:px-8 flex items-center justify-between h-20">
                <a href="{{ route('home') }}" class="flex items-center shrink-0 ml-2 sm:ml-4">
                    @if($siteLogo->logo)
                        <img src="{{ asset('storage/'.$siteLogo->logo) }}" class="h-20 w-auto object-contain">
                    @else
                        <span class="text-4xl text-white">💧</span>
                    @endif
                </a>
                <div class="flex items-center gap-1 text-base font-medium text-white -mr-2 sm:-mr-4">
                    <div class="relative group">
                        <a href="{{ route('about-us.index') }}" class="flex items-center gap-1.5 px-4 py-2 rounded-lg hover:bg-white/10 transition">
                            Tentang Kami
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </a>
                        <div class="nav-dropdown absolute left-0 top-full mt-1 w-64 bg-white rounded-xl shadow-xl border py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-1 group-hover:translate-y-0">
                            <a href="{{ route('about-us.index') }}#sekilas" class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition text-sm">Sekilas PDAM</a>
                            <a href="{{ route('about-us.index') }}#sejarah" class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition text-sm">Sejarah</a>
                            <a href="{{ route('about-us.index') }}#visi-misi" class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition text-sm">Visi &amp; Misi</a>
                            <a href="{{ route('about-us.index') }}#struktur" class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition text-sm">Struktur Organisasi</a>
                            <a href="{{ route('about-us.index') }}#direksi" class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition text-sm">Dewan Direksi &amp; Kuasa Pemilik Modal</a>
                        </div>
                    </div>
                    <div class="relative group">
                        <a href="{{ route('media-informasi.index') }}" class="flex items-center gap-1.5 px-4 py-2 rounded-lg hover:bg-white/10 transition">
                            Media &amp; Informasi
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </a>
                        <div class="nav-dropdown absolute left-0 top-full mt-1 w-60 bg-white rounded-xl shadow-xl border py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-1 group-hover:translate-y-0">
                            <a href="{{ route('news.index') }}" class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition text-sm">Perumdam TDA News</a>
                            <a href="{{ route('announcements.index') }}" class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition text-sm">Pengumuman</a>
                            <a href="{{ route('galleries.index') }}" class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition text-sm">Galeri</a>
                            <a href="{{ route('publications.index') }}" class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition text-sm">Publikasi</a>
                        </div>
                    </div>
                    <a href="{{ route('branches.index') }}" class="px-4 py-2 rounded-lg hover:bg-white/10 transition">Hubungi Kami</a>
                </div>
            </div>
        </div>

        {{-- ---- MODE SCROLLED (sticky, 1 baris) - JS yang toggle 'hidden' di sini ---- --}}
        <div id="navScrolled" class="hidden">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 flex items-center justify-between h-[76px]">
                <a href="{{ route('home') }}" class="flex items-center shrink-0">
                    @if($siteLogo->logo)
                        <img src="{{ asset('storage/'.$siteLogo->logo) }}" class="h-12 w-auto object-contain">
                    @else
                        <span class="text-3xl">💧</span>
                    @endif
                </a>
                <div class="flex items-center gap-1 text-sm font-medium text-slate-800">
                    <div class="relative group">
                        <a href="{{ route('about-us.index') }}" class="flex items-center gap-1 px-3 py-2 rounded-lg hover:bg-slate-100 transition">
                            Tentang Kami
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </a>
                        <div class="nav-dropdown absolute left-0 top-full mt-1 w-64 bg-white rounded-xl shadow-xl border py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-1 group-hover:translate-y-0">
                            <a href="{{ route('about-us.index') }}#sekilas" class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition">Sekilas PDAM</a>
                            <a href="{{ route('about-us.index') }}#sejarah" class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition">Sejarah</a>
                            <a href="{{ route('about-us.index') }}#visi-misi" class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition">Visi &amp; Misi</a>
                            <a href="{{ route('about-us.index') }}#struktur" class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition">Struktur Organisasi</a>
                            <a href="{{ route('about-us.index') }}#direksi" class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition">Dewan Direksi &amp; Kuasa Pemilik Modal</a>
                        </div>
                    </div>
                    <div class="relative group">
                        <a href="{{ route('media-informasi.index') }}" class="flex items-center gap-1 px-3 py-2 rounded-lg hover:bg-slate-100 transition">
                            Media &amp; Informasi
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </a>
                        <div class="nav-dropdown absolute left-0 top-full mt-1 w-60 bg-white rounded-xl shadow-xl border py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-1 group-hover:translate-y-0">
                            <a href="{{ route('news.index') }}" class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition">Perumdam TDA News</a>
                            <a href="{{ route('announcements.index') }}" class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition">Pengumuman</a>
                            <a href="{{ route('galleries.index') }}" class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition">Galeri</a>
                            <a href="{{ route('publications.index') }}" class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition">Publikasi</a>
                        </div>
                    </div>
                    <a href="{{ route('procurement.index') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100 transition">Pengadaan</a>
                    <a href="{{ route('branches.index') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100 transition">Hubungi Kami</a>
                    <a href="{{ route('karir.index') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100 transition">Karir</a>
                    <div class="relative">
                        <button type="button" onclick="toggleSearch('Scrolled')" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-slate-100 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                        </button>
                        <div id="searchBoxScrolled" class="search-dropdown hidden">
                            <form method="GET" action="{{ route('news.index') }}">
                                <input type="text" name="search" placeholder="Cari di Perumdam TDA News..." class="w-64 px-3 py-2 rounded-lg text-sm border shadow-xl focus:ring-2 focus:ring-primary-400">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('pengaduan-online.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold px-4 py-2 rounded-full bg-primary-600 text-white hover:bg-primary-700 hover:shadow-lg hover:scale-105 transition-all">📢 Pengaduan Online</a>
                    <a href="https://pelayananperumdamtda.com/mitra/bayar" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-sm font-semibold px-4 py-2 rounded-full bg-emerald-500 text-white hover:bg-emerald-600 hover:shadow-lg hover:scale-105 transition-all">💳 Cek Tagihan</a>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MOBILE MENU (dropdown sheet) ===== --}}
    <div id="mobileMenu" class="hidden lg:hidden border-t bg-white px-4 py-4 space-y-1 text-sm">
        <a href="{{ route('about-us.index') }}" class="block px-2 py-2 rounded-lg hover:bg-slate-100 font-semibold text-primary-700">Tentang Kami →</a>
        <a href="{{ route('about-us.index') }}#sekilas" class="block px-4 py-2 rounded-lg hover:bg-slate-100 text-slate-600">Sekilas PDAM</a>
        <a href="{{ route('about-us.index') }}#sejarah" class="block px-4 py-2 rounded-lg hover:bg-slate-100 text-slate-600">Sejarah</a>
        <a href="{{ route('about-us.index') }}#visi-misi" class="block px-4 py-2 rounded-lg hover:bg-slate-100 text-slate-600">Visi &amp; Misi</a>
        <a href="{{ route('about-us.index') }}#struktur" class="block px-4 py-2 rounded-lg hover:bg-slate-100 text-slate-600">Struktur Organisasi</a>
        <a href="{{ route('about-us.index') }}#direksi" class="block px-4 py-2 rounded-lg hover:bg-slate-100 text-slate-600">Dewan Direksi</a>
        <div class="border-t my-2"></div>
        <a href="{{ route('media-informasi.index') }}" class="block px-2 py-2 rounded-lg hover:bg-slate-100 font-semibold text-primary-700">Media &amp; Informasi →</a>
        <a href="{{ route('news.index') }}" class="block px-4 py-2 rounded-lg hover:bg-slate-100 text-slate-600">Perumdam TDA News</a>
        <a href="{{ route('announcements.index') }}" class="block px-4 py-2 rounded-lg hover:bg-slate-100 text-slate-600">Pengumuman</a>
        <a href="{{ route('galleries.index') }}" class="block px-4 py-2 rounded-lg hover:bg-slate-100 text-slate-600">Galeri</a>
        <a href="{{ route('publications.index') }}" class="block px-4 py-2 rounded-lg hover:bg-slate-100 text-slate-600">Publikasi</a>
        <div class="border-t my-2"></div>
        <a href="{{ route('procurement.index') }}" class="block px-2 py-2 rounded-lg hover:bg-slate-100 font-medium">Pengadaan</a>
        <a href="{{ route('branches.index') }}" class="block px-2 py-2 rounded-lg hover:bg-slate-100 font-medium">Hubungi Kami</a>
        <a href="{{ route('karir.index') }}" class="block px-2 py-2 rounded-lg hover:bg-slate-100 font-medium">Karir</a>
        <div class="border-t my-2"></div>
        <a href="{{ route('pengaduan-online.index') }}" class="block text-center px-2 py-2.5 rounded-full bg-primary-600 text-white font-semibold">📢 Pengaduan Online</a>
        <a href="https://pelayananperumdamtda.com/mitra/bayar" target="_blank" rel="noopener" class="block text-center px-2 py-2.5 rounded-full bg-emerald-500 text-white font-semibold mt-2">💳 Cek Tagihan</a>
    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="bg-primary-900 text-primary-100 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid md:grid-cols-4 gap-8 text-sm">
        <div>
            <div class="flex items-center gap-2 mb-3">
                @if($siteLogo->logo)
                    <img src="{{ asset('storage/'.$siteLogo->logo) }}" class="h-12 w-auto object-contain">
                @else
                    <span class="font-bold text-white text-lg">💧 PERUMDAM Tirta Darma Ayu</span>
                @endif
            </div>
            <p class="text-primary-200">Badan Usaha Milik Daerah penyedia air bersih untuk masyarakat Kabupaten Indramayu.</p>

            <div class="flex items-center gap-3 mt-4">
                <a href="https://www.instagram.com/perumdamtda_indramayu" target="_blank" rel="noopener" aria-label="Instagram"
                   class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                    <svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                </a>
                <a href="https://www.facebook.com/perumdamtdaindramayu" target="_blank" rel="noopener" aria-label="Facebook"
                   class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                    <svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.988h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                </a>
                <a href="https://youtube.com/@humastirtadarmaayu1452" target="_blank" rel="noopener" aria-label="YouTube"
                   class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                    <svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                </a>
            </div>
        </div>
        <div>
            <div class="font-semibold text-white mb-2">Tentang Kami</div>
            <ul class="space-y-1 text-primary-200">
                <li><a href="{{ route('about-us.index') }}" class="hover:text-white transition">Profil Perusahaan</a></li>
                <li><a href="{{ route('news.index') }}" class="hover:text-white transition">Perumdam TDA News</a></li>
                <li><a href="{{ route('publications.index') }}" class="hover:text-white transition">Dokumen &amp; Publikasi</a></li>
            </ul>
        </div>
        <div>
            <div class="font-semibold text-white mb-2">Layanan</div>
            <ul class="space-y-1 text-primary-200">
                <li><a href="{{ route('pengaduan-online.index') }}" class="hover:text-white transition">Pengaduan Online</a></li>
                <li><a href="https://pelayananperumdamtda.com/mitra/bayar" target="_blank" rel="noopener" class="hover:text-white transition">Cek Tagihan</a></li>
                <li><a href="{{ route('branches.index') }}" class="hover:text-white transition">Peta Cabang Layanan</a></li>
                <li><a href="{{ route('karir.index') }}" class="hover:text-white transition">Karir</a></li>
            </ul>
        </div>
        <div>
            <div class="font-semibold text-white mb-2">Kantor Pusat</div>
            <p class="text-primary-200">Jl. Letjend. Suprapto No.25/E, Kepandean, Indramayu</p>
            <p class="text-primary-200">Telp: (0234) 271311</p>
        </div>
    </div>
    <div class="border-t border-primary-800 text-center text-xs text-primary-300 py-4">
        © {{ date('Y') }} PERUMDAM Tirta Darma Ayu — Kabupaten Indramayu.
    </div>
</footer>

@include('partials.lightbox')
@include('partials.chatbot-widget')
<script>
    document.getElementById('mobileMenuBtn')?.addEventListener('click', function () {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    });

    (function () {
        const header = document.getElementById('mainHeader');
        const navRegular = document.getElementById('navRegular');
        const navScrolled = document.getElementById('navScrolled');

        function updateNav() {
            const scrolled = window.scrollY > 40;
            header.classList.toggle('nav-scrolled', scrolled);
            navRegular.classList.toggle('hidden', scrolled);
            navScrolled.classList.toggle('hidden', !scrolled);
        }
        window.addEventListener('scroll', updateNav, { passive: true });
        updateNav();
    })();

    function toggleSearch(which) {
        document.getElementById('searchBox' + which).classList.toggle('hidden');
    }

    // klik di luar search box -> nutup otomatis
    document.addEventListener('click', function (e) {
        ['Regular', 'Scrolled'].forEach(which => {
            const box = document.getElementById('searchBox' + which);
            if (!box || box.classList.contains('hidden')) return;
            if (!box.parentElement.contains(e.target)) box.classList.add('hidden');
        });
    });
</script>
@stack('scripts')
</body>
</html>
