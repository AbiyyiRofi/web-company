<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Portal Internal PDAM TDA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { colors: { primary: {50:'#eff6ff',100:'#dbeafe',500:'#2563eb',600:'#1d4ed8',700:'#1e40af',900:'#1e3a8a'} } } } }</script>
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-800">
@php
    $siteLogo = \App\Models\SiteSetting::singleton();
@endphp
<div class="flex min-h-screen">
    <aside class="w-72 bg-primary-900 text-white flex flex-col">
        <div class="p-5 border-b border-primary-800 flex items-center gap-2">
            @if($siteLogo->logo)
                <img src="{{ asset('storage/'.$siteLogo->logo) }}" class="h-9 w-auto object-contain">
            @else
                <span class="text-xl">💧</span>
            @endif
            <div>
                <div class="font-bold text-sm leading-tight">Portal Internal</div>
                <div class="text-xs text-primary-300">Admin — {{ auth()->user()->name }}</div>
            </div>
        </div>
        <nav class="flex-1 p-4 space-y-1 text-sm overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg hover:bg-primary-800 {{ request()->routeIs('admin.dashboard') ? 'bg-primary-800' : '' }}">📊 Dashboard</a>
            <a href="{{ route('admin.highlights.index') }}" class="block px-3 py-2 rounded-lg hover:bg-primary-800 {{ request()->routeIs('admin.highlights.*') ? 'bg-primary-800' : '' }}">📈 Highlight Beranda</a>

            <details class="group" {{ request()->routeIs('admin.about-us.*') || request()->routeIs('admin.directors.*') ? 'open' : '' }}>
                <summary class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-primary-800 cursor-pointer list-none">
                    <span>🏢 Tentang Kami</span>
                    <svg class="w-3.5 h-3.5 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </summary>
                <div class="pl-4 mt-1 space-y-1">
                    <a href="{{ route('admin.about-us.edit') }}" class="block px-3 py-1.5 rounded-lg hover:bg-primary-800 text-primary-200 {{ request()->routeIs('admin.about-us.edit') ? 'bg-primary-800 text-white' : '' }}">Konten Halaman</a>
                    <a href="{{ route('admin.directors.index') }}" class="block px-3 py-1.5 rounded-lg hover:bg-primary-800 text-primary-200 {{ request()->routeIs('admin.directors.*') ? 'bg-primary-800 text-white' : '' }}">Dewan Direksi</a>
                </div>
            </details>

            <details class="group" {{ request()->routeIs('admin.news.*') || request()->routeIs('admin.announcements.*') || request()->routeIs('admin.galleries.*') || request()->routeIs('admin.publications.*') || request()->routeIs('admin.page-headers.*') ? 'open' : '' }}>
                <summary class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-primary-800 cursor-pointer list-none">
                    <span>📰 Media &amp; Informasi</span>
                    <svg class="w-3.5 h-3.5 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </summary>
                <div class="pl-4 mt-1 space-y-1">
                    <span class="block px-3 pt-1 text-[11px] uppercase text-primary-400">Perumdam TDA News</span>
                    <a href="{{ route('admin.news.index') }}" class="block px-3 py-1.5 rounded-lg hover:bg-primary-800 text-primary-200 {{ request()->routeIs('admin.news.*') ? 'bg-primary-800 text-white' : '' }}">Kelola Isi</a>
                    <a href="{{ route('admin.page-headers.edit', 'news') }}" class="block px-3 py-1.5 rounded-lg hover:bg-primary-800 text-primary-200 {{ request()->is('portal-internal/page-header/news') ? 'bg-primary-800 text-white' : '' }}">Header Halaman</a>
                    <span class="block px-3 pt-2 text-[11px] uppercase text-primary-400">Pengumuman</span>
                    <a href="{{ route('admin.announcements.index') }}" class="block px-3 py-1.5 rounded-lg hover:bg-primary-800 text-primary-200 {{ request()->routeIs('admin.announcements.*') ? 'bg-primary-800 text-white' : '' }}">Kelola Isi</a>
                    <a href="{{ route('admin.page-headers.edit', 'pengumuman') }}" class="block px-3 py-1.5 rounded-lg hover:bg-primary-800 text-primary-200 {{ request()->is('portal-internal/page-header/pengumuman') ? 'bg-primary-800 text-white' : '' }}">Header Halaman</a>
                    <span class="block px-3 pt-2 text-[11px] uppercase text-primary-400">Galeri</span>
                    <a href="{{ route('admin.galleries.index') }}" class="block px-3 py-1.5 rounded-lg hover:bg-primary-800 text-primary-200 {{ request()->routeIs('admin.galleries.*') ? 'bg-primary-800 text-white' : '' }}">Kelola Isi</a>
                    <a href="{{ route('admin.page-headers.edit', 'galeri') }}" class="block px-3 py-1.5 rounded-lg hover:bg-primary-800 text-primary-200 {{ request()->is('portal-internal/page-header/galeri') ? 'bg-primary-800 text-white' : '' }}">Header Halaman</a>
                    <span class="block px-3 pt-2 text-[11px] uppercase text-primary-400">Publikasi</span>
                    <a href="{{ route('admin.publications.index') }}" class="block px-3 py-1.5 rounded-lg hover:bg-primary-800 text-primary-200 {{ request()->routeIs('admin.publications.*') ? 'bg-primary-800 text-white' : '' }}">Kelola Isi</a>
                    <a href="{{ route('admin.page-headers.edit', 'publikasi') }}" class="block px-3 py-1.5 rounded-lg hover:bg-primary-800 text-primary-200 {{ request()->is('portal-internal/page-header/publikasi') ? 'bg-primary-800 text-white' : '' }}">Header Halaman</a>
                </div>
            </details>

            <a href="{{ route('admin.procurement.index') }}" class="block px-3 py-2 rounded-lg hover:bg-primary-800 {{ request()->routeIs('admin.procurement.*') ? 'bg-primary-800' : '' }}">📄 Pengadaan</a>

            <details class="group" {{ request()->routeIs('admin.branches.*') ? 'open' : '' }}>
                <summary class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-primary-800 cursor-pointer list-none">
                    <span>📍 Hubungi Kami</span>
                    <svg class="w-3.5 h-3.5 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </summary>
                <div class="pl-4 mt-1 space-y-1">
                    <a href="{{ route('admin.branches.index') }}" class="block px-3 py-1.5 rounded-lg hover:bg-primary-800 text-primary-200 {{ request()->routeIs('admin.branches.index') ? 'bg-primary-800 text-white' : '' }}">Kelola Cabang</a>
                </div>
            </details>

            <a href="{{ route('admin.karir.edit') }}" class="block px-3 py-2 rounded-lg hover:bg-primary-800 {{ request()->routeIs('admin.karir.*') ? 'bg-primary-800' : '' }}">💼 Karir</a>
            <a href="{{ route('admin.pengaduan-online.edit') }}" class="block px-3 py-2 rounded-lg hover:bg-primary-800 {{ request()->routeIs('admin.pengaduan-online.*') ? 'bg-primary-800' : '' }}">📢 Pengaduan Online</a>
            <a href="{{ route('admin.header-slides.index') }}" class="block px-3 py-2 rounded-lg hover:bg-primary-800 {{ request()->routeIs('admin.header-slides.*') ? 'bg-primary-800' : '' }}">🖼️ Poster Header Beranda</a>
            <a href="{{ route('admin.settings.edit') }}" class="block px-3 py-2 rounded-lg hover:bg-primary-800 {{ request()->routeIs('admin.settings.*') ? 'bg-primary-800' : '' }}">⚙️ Pengaturan Logo</a>

            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-primary-800 mt-4 border-t border-primary-800 pt-4">← Lihat Website Publik</a>
        </nav>
        <form method="POST" action="{{ route('admin.logout') }}" class="p-4 border-t border-primary-800">
            @csrf
            <button class="w-full text-left px-3 py-2 rounded-lg hover:bg-primary-800 text-sm">Logout</button>
        </form>
    </aside>

    <div class="flex-1 flex flex-col">
        <header class="bg-white border-b px-6 py-4 flex items-center justify-between">
            <h1 class="text-lg font-semibold">@yield('title', 'Dashboard')</h1>
        </header>
        <main class="flex-1 p-6">
            @if (session('success'))
                <div class="mb-4 bg-green-100 text-green-800 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 text-red-800 px-4 py-3 rounded-lg text-sm">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-4 bg-red-100 text-red-800 px-4 py-3 rounded-lg text-sm">
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>

@include('partials.lightbox')
<script src="{{ asset('js/multi-image-uploader.js') }}"></script>
@stack('scripts')
</body>
</html>
