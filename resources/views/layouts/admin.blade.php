<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Portal Internal PDAM TDA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] }, colors: { primary: {50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',300:'#93c5fd',400:'#60a5fa',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8a'}, brand: {50:'#f0f9ff',100:'#e0f2fe',500:'#0ea5e9',600:'#0284c7'} } } } }</script>
    <style>
        /* ━━━ Admin Panel Custom Styles ━━━ */
        * { font-family: 'Inter', system-ui, sans-serif; }

        /* Sidebar */
        .admin-sidebar { background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%); border-right: 1px solid #e2e8f0; }
        .admin-sidebar::-webkit-scrollbar { width: 4px; }
        .admin-sidebar::-webkit-scrollbar-track { background: transparent; }
        .admin-sidebar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }

        /* Nav Item */
        .nav-item { display: flex; align-items: center; gap: 0.625rem; padding: 0.5rem 0.75rem; border-radius: 0.625rem; font-size: 0.8125rem; font-weight: 500; color: #475569; transition: all 0.2s cubic-bezier(0.4,0,0.2,1); position: relative; }
        .nav-item:hover { background: #e2e8f0; color: #1e293b; }
        .nav-item.active { background: #dbeafe; color: #1d4ed8; font-weight: 600; }
        .nav-item.active .nav-icon { color: #2563eb; }
        .nav-item .nav-icon { width: 1.125rem; height: 1.125rem; color: #94a3b8; flex-shrink: 0; transition: color 0.2s; }
        .nav-item:hover .nav-icon { color: #64748b; }

        /* Sub Nav */
        .sub-nav-item { display: block; padding: 0.375rem 0.75rem 0.375rem 2.75rem; border-radius: 0.5rem; font-size: 0.8125rem; font-weight: 500; color: #64748b; transition: all 0.2s; position: relative; }
        .sub-nav-item::before { content: ''; position: absolute; left: 1.75rem; top: 50%; width: 4px; height: 4px; border-radius: 999px; background: #cbd5e1; transform: translateY(-50%); transition: background 0.2s; }
        .sub-nav-item:hover { color: #1e293b; background: #f1f5f9; }
        .sub-nav-item:hover::before { background: #94a3b8; }
        .sub-nav-item.active { color: #1d4ed8; font-weight: 600; background: #eff6ff; }
        .sub-nav-item.active::before { background: #2563eb; width: 6px; height: 6px; }

        /* Section label */
        .nav-section-label { display: block; padding: 0.25rem 0.75rem 0.125rem 2.75rem; font-size: 0.625rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #94a3b8; }

        /* Details arrow */
        .nav-details summary { list-style: none; }
        .nav-details summary::-webkit-details-marker { display: none; }
        .nav-details .chevron-icon { transition: transform 0.25s cubic-bezier(0.4,0,0.2,1); }
        .nav-details[open] .chevron-icon { transform: rotate(180deg); }
        .nav-details .sub-menu { overflow: hidden; animation: slideDown 0.25s ease; }
        @keyframes slideDown { from { opacity: 0; max-height: 0; } to { opacity: 1; max-height: 500px; } }

        /* Header */
        .admin-header { background: rgba(255,255,255,0.85); backdrop-filter: blur(12px) saturate(180%); -webkit-backdrop-filter: blur(12px) saturate(180%); border-bottom: 1px solid #e2e8f0; }

        /* Stat cards hover */
        .stat-card { transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 24px -8px rgba(0,0,0,0.1); }

        /* Flash message animation */
        .flash-msg { animation: flashIn 0.4s ease; }
        @keyframes flashIn { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }

        /* Table style */
        .admin-table { width: 100%; font-size: 0.875rem; }
        .admin-table thead { background: #f8fafc; }
        .admin-table th { padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: #64748b; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.04em; white-space: nowrap; }
        .admin-table td { padding: 0.75rem 1rem; }
        .admin-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background 0.15s; }
        .admin-table tbody tr:hover { background: #f8fafc; }

        /* Form elements */
        .admin-input { width: 100%; border: 1px solid #e2e8f0; border-radius: 0.625rem; padding: 0.5rem 0.75rem; font-size: 0.875rem; transition: all 0.2s; background: #fff; }
        .admin-input:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.12); }

        /* Buttons */
        .btn-primary { display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.5rem 1.125rem; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; border-radius: 0.625rem; font-size: 0.8125rem; font-weight: 600; transition: all 0.2s; box-shadow: 0 1px 3px rgba(37,99,235,0.3); }
        .btn-primary:hover { background: linear-gradient(135deg, #1d4ed8, #1e40af); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37,99,235,0.35); }
        .btn-secondary { display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.5rem 1.125rem; background: #fff; color: #475569; border: 1px solid #e2e8f0; border-radius: 0.625rem; font-size: 0.8125rem; font-weight: 500; transition: all 0.2s; }
        .btn-secondary:hover { background: #f8fafc; border-color: #cbd5e1; }
        .btn-danger { display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.375rem 0.75rem; color: #dc2626; font-size: 0.8125rem; font-weight: 500; border-radius: 0.5rem; transition: all 0.2s; }
        .btn-danger:hover { background: #fef2f2; }

        /* Card */
        .admin-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 0.875rem; overflow: hidden; }

        /* Leaflet z-index fix for admin pages */
        .admin-main .leaflet-pane, .admin-main .leaflet-top, .admin-main .leaflet-bottom, .admin-main .leaflet-control { z-index: 5 !important; }
        .admin-main #pickMap { position: relative; z-index: 1; }

        /* Responsive table wrapper */
        .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; border-radius: 0.875rem; border: 1px solid #e2e8f0; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
@php
    $siteLogo = \App\Models\SiteSetting::singleton();
@endphp
<div x-data="{ sidebarOpen: false }" class="min-h-screen flex">

    {{-- ━━━ BACKDROP (Mobile/Tablet) ━━━ --}}
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden"
         style="display: none;"></div>

    {{-- ━━━ SIDEBAR ━━━ --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="admin-sidebar fixed inset-y-0 left-0 z-50 w-[260px] flex flex-col transition-transform duration-300 ease-out lg:static lg:z-auto shrink-0">

        {{-- Logo Section --}}
        <div class="p-4 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                @if($siteLogo->logo)
                    <div class="w-9 h-9 rounded-lg bg-primary-600 flex items-center justify-center p-1 shadow-sm">
                        <img src="{{ asset('storage/'.$siteLogo->logo) }}" class="h-full w-full object-contain" alt="Logo">
                    </div>
                @else
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    </div>
                @endif
                <div class="min-w-0">
                    <div class="font-bold text-sm text-slate-800 leading-tight truncate">Portal Admin</div>
                    <div class="text-[11px] text-slate-400 truncate">PERUMDAM TDA</div>
                </div>
            </div>
            {{-- Close button (mobile/tablet) --}}
            <button @click="sidebarOpen = false" class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-200 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 pb-3 space-y-0.5 overflow-y-auto">

            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                Dashboard
            </a>

            {{-- Highlight Beranda --}}
            <a href="{{ route('admin.highlights.index') }}" class="nav-item {{ request()->routeIs('admin.highlights.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/></svg>
                Highlight Beranda
            </a>

            {{-- Tentang Kami --}}
            <details class="nav-details group" {{ request()->routeIs('admin.about-us.*') || request()->routeIs('admin.directors.*') || request()->routeIs('admin.history.*') || request()->routeIs('admin.leadership-history.*') ? 'open' : '' }}>
                <summary class="nav-item cursor-pointer">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                    <span class="flex-1">Tentang Kami</span>
                    <svg class="chevron-icon w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </summary>
                <div class="sub-menu mt-0.5 space-y-0.5">
                    <a href="{{ route('admin.about-us.edit') }}" class="sub-nav-item {{ request()->routeIs('admin.about-us.edit') ? 'active' : '' }}">Konten Halaman</a>
                    <a href="{{ route('admin.history.index') }}" class="sub-nav-item {{ request()->routeIs('admin.history.*') ? 'active' : '' }}">Sejarah (Per Tahun)</a>
                    <a href="{{ route('admin.leadership-history.index') }}" class="sub-nav-item {{ request()->routeIs('admin.leadership-history.*') ? 'active' : '' }}">Sejarah Kepemimpinan</a>
                    <a href="{{ route('admin.directors.index') }}" class="sub-nav-item {{ request()->routeIs('admin.directors.*') ? 'active' : '' }}">Jajaran Direksi</a>
                </div>
            </details>

            {{-- Media & Informasi --}}
            <details class="nav-details group" {{ request()->routeIs('admin.news.*') || request()->routeIs('admin.announcements.*') || request()->routeIs('admin.galleries.*') || request()->routeIs('admin.publications.*') || request()->routeIs('admin.page-headers.*') ? 'open' : '' }}>
                <summary class="nav-item cursor-pointer">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
                    <span class="flex-1">Media & Informasi</span>
                    <svg class="chevron-icon w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </summary>
                <div class="sub-menu mt-0.5 space-y-0.5">
                    <span class="nav-section-label">Perumdam TDA News</span>
                    <a href="{{ route('admin.news.index') }}" class="sub-nav-item {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">Kelola Isi</a>
                    <a href="{{ route('admin.page-headers.edit', 'news') }}" class="sub-nav-item {{ request()->is('portal-internal/page-header/news') ? 'active' : '' }}">Header Halaman</a>
                    <span class="nav-section-label">Pengumuman</span>
                    <a href="{{ route('admin.announcements.index') }}" class="sub-nav-item {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">Kelola Isi</a>
                    <a href="{{ route('admin.page-headers.edit', 'pengumuman') }}" class="sub-nav-item {{ request()->is('portal-internal/page-header/pengumuman') ? 'active' : '' }}">Header Halaman</a>
                    <span class="nav-section-label">Galeri</span>
                    <a href="{{ route('admin.galleries.index') }}" class="sub-nav-item {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}">Kelola Isi</a>
                    <a href="{{ route('admin.page-headers.edit', 'galeri') }}" class="sub-nav-item {{ request()->is('portal-internal/page-header/galeri') ? 'active' : '' }}">Header Halaman</a>
                    <span class="nav-section-label">Publikasi</span>
                    <a href="{{ route('admin.publications.index') }}" class="sub-nav-item {{ request()->routeIs('admin.publications.*') ? 'active' : '' }}">Kelola Isi</a>
                    <a href="{{ route('admin.page-headers.edit', 'publikasi') }}" class="sub-nav-item {{ request()->is('portal-internal/page-header/publikasi') ? 'active' : '' }}">Header Halaman</a>
                </div>
            </details>

            {{-- Pengadaan --}}
            <a href="{{ route('admin.procurement.index') }}" class="nav-item {{ request()->routeIs('admin.procurement.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                Pengadaan
            </a>

            {{-- Hubungi Kami --}}
            <details class="nav-details group" {{ request()->routeIs('admin.branches.*') ? 'open' : '' }}>
                <summary class="nav-item cursor-pointer">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                    <span class="flex-1">Hubungi Kami</span>
                    <svg class="chevron-icon w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </summary>
                <div class="sub-menu mt-0.5 space-y-0.5">
                    <a href="{{ route('admin.branches.index') }}" class="sub-nav-item {{ request()->routeIs('admin.branches.index') ? 'active' : '' }}">Kelola Cabang</a>
                </div>
            </details>

            {{-- Karir --}}
            <a href="{{ route('admin.karir.edit') }}" class="nav-item {{ request()->routeIs('admin.karir.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"/></svg>
                Karir
            </a>

            {{-- Pengaduan Online --}}
            <a href="{{ route('admin.pengaduan-online.edit') }}" class="nav-item {{ request()->routeIs('admin.pengaduan-online.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46"/></svg>
                Pengaduan Online
            </a>

            {{-- Poster Header Beranda --}}
            <a href="{{ route('admin.header-slides.index') }}" class="nav-item {{ request()->routeIs('admin.header-slides.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v13.5a1.5 1.5 0 001.5 1.5zm7.5-12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                Poster Header
            </a>

            {{-- Pengaturan Logo --}}
            <a href="{{ route('admin.settings.edit') }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Pengaturan Logo
            </a>

            {{-- Super Admin Area --}}
            @if(auth()->user()->isSuperAdmin())
                <div class="!mt-4 pt-3 border-t border-slate-200 space-y-0.5">
                    <span class="nav-section-label !px-3 !text-[10px] !text-purple-600 !font-bold tracking-wider">Super Admin Area</span>
                    
                    {{-- Log Activity --}}
                    <a href="{{ route('admin.activity-logs.index') }}" class="nav-item {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
                        <svg class="nav-icon text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Log Activity
                    </a>

                    {{-- Kelola Admin --}}
                    <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <svg class="nav-icon text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                        Kelola Admin
                    </a>
                </div>
            @endif

            {{-- Divider + External --}}
            <div class="!mt-4 pt-3 border-t border-slate-200">
                <a href="{{ route('home') }}" class="nav-item text-slate-400 hover:text-primary-600" target="_blank">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                    Lihat Website Publik
                </a>
            </div>
        </nav>

        {{-- User & Logout --}}
        <div class="p-3 border-t border-slate-200">
            <form method="POST" action="{{ route('admin.logout') }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-100 transition group">
                @csrf
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-full {{ auth()->user()->isSuperAdmin() ? 'bg-gradient-to-br from-purple-500 to-indigo-600' : 'bg-gradient-to-br from-primary-400 to-primary-600' }} flex items-center justify-center text-white text-xs font-bold shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="text-xs font-semibold text-slate-700 truncate">{{ auth()->user()->name }}</div>
                        <div class="text-[10px] {{ auth()->user()->isSuperAdmin() ? 'text-purple-600 font-bold' : 'text-slate-400' }}">
                            {{ auth()->user()->isSuperAdmin() ? 'Super Admin' : 'Administrator' }}
                        </div>
                    </div>
                </div>
                <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition" title="Logout">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                </button>
            </form>
        </div>
    </aside>

    {{-- ━━━ MAIN CONTENT ━━━ --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- Header --}}
        <header class="admin-header sticky top-0 z-30 px-4 sm:px-6 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                {{-- Hamburger (mobile/tablet) --}}
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-slate-500 hover:text-slate-700 hover:bg-slate-100 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                </button>
                <div>
                    <h1 class="text-base sm:text-lg font-bold text-slate-800 truncate">@yield('title', 'Dashboard')</h1>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="hidden sm:inline text-xs text-slate-400">{{ now()->translatedFormat('l, d M Y') }}</span>
                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center lg:hidden">
                    <span class="text-xs font-bold text-primary-600">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <main class="admin-main flex-1 p-4 sm:p-6 overflow-x-hidden">
            @if (session('success'))
                <div class="flash-msg mb-5 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="flash-msg mb-5 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="flash-msg mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                    <div class="flex items-center gap-2 font-medium mb-1">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        Terdapat kesalahan:
                    </div>
                    <ul class="list-disc pl-8 space-y-0.5">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </main>
    </div>

</div>

<!-- SweetAlert2 CDN & Global Auto-Confirm Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .swal2-popup { border-radius: 1.25rem !important; font-family: 'Inter', system-ui, sans-serif !important; padding: 1.5rem !important; }
    .swal2-styled.swal2-confirm { border-radius: 0.75rem !important; padding: 0.6rem 1.5rem !important; font-weight: 600 !important; }
    .swal2-styled.swal2-cancel { background-color: #f1f5f9 !important; color: #475569 !important; border-radius: 0.75rem !important; padding: 0.6rem 1.5rem !important; font-weight: 600 !important; }
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Intercept Form Logout Admin
    const logoutForm = document.querySelector('form[action*="logout"]');
    if (logoutForm) {
        logoutForm.addEventListener('submit', function (e) {
            if (!this.dataset.confirmed) {
                e.preventDefault();
                Swal.fire({
                    title: 'Keluar dari Portal Admin?',
                    text: 'Anda harus login kembali untuk mengelola konten website.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2563eb',
                    cancelButtonColor: '#f1f5f9',
                    confirmButtonText: 'Ya, Logout',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.dataset.confirmed = 'true';
                        this.submit();
                    }
                });
            }
        });
    }

    // 2. Global Interceptor untuk Seluruh Form Hapus (onsubmit confirm)
    document.querySelectorAll('form').forEach(form => {
        const onsubmitAttr = form.getAttribute('onsubmit');
        if (onsubmitAttr && onsubmitAttr.includes('confirm')) {
            form.removeAttribute('onsubmit');
            form.addEventListener('submit', function (e) {
                if (!this.dataset.confirmed) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Konfirmasi Hapus Data',
                        text: 'Apakah Anda yakin ingin menghapus data ini secara permanen?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#f1f5f9',
                        confirmButtonText: 'Ya, Hapus Data',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.dataset.confirmed = 'true';
                            this.submit();
                        }
                    });
                }
            });
        }
    });
});
</script>

<!-- Alpine JS for sidebar interactivity -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@include('partials.lightbox')
<script src="{{ asset('js/multi-image-uploader.js') }}"></script>
@stack('scripts')
</body>
</html>
