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
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: { 50: '#eff6ff', 100: '#dbeafe', 400: '#60a5fa', 500: '#3b82f6', 600: '#1d4ed8', 700: '#1e40af', 800: '#1e3a8a', 900: '#172554' }
                    }
                }
            }
        }
    </script>
    <script>
        // Init dark mode immediately to avoid screen flicker (FOUC)
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    <style>
        /* ==========================================================================
           MASTER DESIGN SYSTEM & DARK MODE OVERRIDES
           - Menyelaraskan latar belakang antar section (mencegah belang-belang)
           - Membawa elemen warna biru tua ke warna versi muda/terang yang "hidup"
           ========================================================================== */

        /* Smooth Mode Transition */
        html { transition: background-color 0.3s ease, color 0.3s ease; }
        html.dark body,
        html.dark main,
        html.dark section,
        html.dark div,
        html.dark card { transition: background-color 0.3s ease, color 0.2s ease, border-color 0.3s ease, box-shadow 0.3s ease; }

        /* --- 1. UNIFIED CANVAS & GLOBAL BACKGROUNDS --- */
        html.dark body,
        html.dark main {
            background-color: #090d16 !important; /* Unified dark obsidian background */
            color: #f1f5f9 !important;
        }

        /* Standardize all section backgrounds in Dark Mode to prevent patchwork / belang-belang */
        html.dark section {
            background-color: transparent !important;
        }
        html.dark section.bg-white,
        html.dark section.bg-slate-50,
        html.dark section.bg-slate-100,
        html.dark section.bg-slate-900,
        html.dark section.bg-primary-900,
        html.dark section.bg-primary-800 {
            background-color: transparent !important;
            border-color: rgba(51, 65, 85, 0.4) !important;
        }

        /* --- 2. DARK BLUE ELEMENTS TRANSFORM (TIDAK LAGI WARNA MATI) --- */
        /* Mengubah container/card bernuansa biru tua/gelap di mode biasa menjadi warna versi muda/terang & bercahaya di Dark Mode */
        
        /* Dark Primary Cards & Banner Containers (Home Media Cards, Hero Banner, dll) */
        html.dark .bg-primary-900,
        html.dark .bg-primary-800,
        html.dark .bg-primary-700,
        html.dark .bg-slate-900,
        html.dark .bg-blue-900 {
            background-color: #111a2e !important;
            border: 1px solid rgba(56, 189, 248, 0.35) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.05) !important;
        }

        /* Hover state untuk kartu .bg-primary-800 / dark blue cards di mode gelap */
        html.dark a.bg-primary-800:hover,
        html.dark a.bg-primary-900:hover,
        html.dark div.bg-primary-800:hover {
            background-color: #1a2742 !important;
            border-color: rgba(56, 189, 248, 0.6) !important;
            box-shadow: 0 8px 30px rgba(56, 189, 248, 0.2) !important;
        }

        /* Text & Subtitles inside Dark Blue Containers in Dark Mode */
        html.dark .bg-primary-900 *,
        html.dark .bg-primary-800 *,
        html.dark .bg-primary-700 * {
            color: #f8fafc;
        }
        html.dark .bg-primary-900 .text-primary-100,
        html.dark .bg-primary-800 .text-primary-100,
        html.dark .bg-primary-700 .text-primary-100 {
            color: #7dd3fc !important; /* Sky blue muda yang segar dan sangat mudah dibaca */
        }

        /* Light Blue Containers (.bg-primary-100, .bg-primary-50) in Dark Mode */
        html.dark .bg-primary-100,
        html.dark .bg-primary-50,
        html.dark .bg-sky-50 {
            background-color: #131e33 !important;
            border: 1px solid rgba(56, 189, 248, 0.25) !important;
            color: #e2e8f0 !important;
        }
        html.dark .bg-primary-100 .text-primary-600,
        html.dark .bg-primary-50 .text-primary-600 {
            color: #38bdf8 !important; /* Cyan terang */
        }
        html.dark .bg-primary-100 .text-slate-600,
        html.dark .bg-primary-50 .text-slate-600 {
            color: #cbd5e1 !important;
        }

        /* --- 3. STANDARD CARDS & ELEVATED SURFACES --- */
        html.dark .bg-white {
            background-color: #131c2e !important;
        }
        html.dark .bg-slate-50,
        html.dark .bg-slate-100 {
            background-color: #162238 !important;
        }

        html.dark .rounded-2xl.bg-white,
        html.dark .rounded-xl.bg-white,
        html.dark .rounded-lg.bg-white,
        html.dark a.bg-white,
        html.dark div.bg-white {
            background-color: #131c2e !important;
            border-color: #23334d !important;
        }

        /* Borders & Dividers */
        html.dark .border,
        html.dark .border-slate-100,
        html.dark .border-slate-200,
        html.dark .border-slate-300 {
            border-color: #23334d !important;
        }
        html.dark .divide-slate-100 > * + * { border-color: #23334d !important; }
        html.dark .border-t { border-top-color: #23334d !important; }
        html.dark .border-b { border-bottom-color: #23334d !important; }

        /* --- 4. TEXT COLOR ACCENTS & READABILITY --- */
        html.dark .text-slate-900,
        html.dark .text-slate-800 { color: #f8fafc !important; }
        html.dark .text-slate-700,
        html.dark .text-slate-600 { color: #cbd5e1 !important; }
        html.dark .text-slate-500,
        html.dark .text-slate-400 { color: #94a3b8 !important; }
        
        html.dark .text-primary-600,
        html.dark .text-primary-700,
        html.dark .text-sky-600 { color: #38bdf8 !important; } /* Sky/cyan muda bercahaya */
        
        html.dark h1, html.dark h2, html.dark h3, html.dark h4 {
            color: #f8fafc !important;
        }
        html.dark .prose { color: #cbd5e1 !important; }
        html.dark #activeDirectorName { color: #f8fafc !important; }
        html.dark #activeDirectorPeriod { color: #38bdf8 !important; }
        html.dark #activeDirectorPosition { color: #7dd3fc !important; }

        /* --- 5. HEADER & NAVBAR --- */
        html.dark #mainHeader.nav-scrolled {
            background: rgba(9, 13, 22, 0.95) !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.5);
            border-bottom: 1px solid rgba(56, 189, 248, 0.15);
        }
        html.dark #mainHeader.nav-scrolled .mobile-icon {
            color: #f8fafc !important;
            background-color: rgba(20, 28, 44, 0.9) !important;
            border-color: rgba(56, 189, 248, 0.3) !important;
        }
        html.dark #mainHeader.nav-scrolled a,
        html.dark #mainHeader.nav-scrolled button {
            color: #f8fafc !important;
        }
        html.dark #mainHeader.nav-scrolled .hover\:bg-slate-100:hover {
            background-color: #1e2d42 !important;
        }
        html.dark .nav-dropdown {
            background-color: #141c2c !important;
            border-color: rgba(56, 189, 248, 0.25) !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5) !important;
        }
        html.dark .nav-dropdown a {
            color: #cbd5e1 !important;
        }
        html.dark .nav-dropdown a:hover {
            background-color: #1e2d42 !important;
            color: #38bdf8 !important;
        }

        /* --- 6. MOBILE DRAWER --- */
        html.dark #mobileDrawer {
            background-color: rgba(9, 13, 22, 0.98) !important;
            color: #f8fafc !important;
        }
        html.dark #mobileDrawer nav button,
        html.dark #mobileDrawer nav a {
            color: #e2e8f0 !important;
        }
        html.dark #mobileDrawer .bg-slate-50\/50,
        html.dark #mobileDrawer .bg-slate-50\/80 {
            background-color: rgba(20, 28, 44, 0.7) !important;
            border-color: #27364d !important;
        }
        html.dark #mobileDrawer .bg-white\/70 {
            background-color: rgba(20, 28, 44, 0.8) !important;
        }
        html.dark #mobileDrawer input {
            background-color: #141c2c !important;
            color: #f1f5f9 !important;
            border-color: #27364d !important;
        }
        html.dark #mobileDrawerCloseBtn {
            background-color: #1e2d42 !important;
            color: #e2e8f0 !important;
        }
        html.dark #mobileBackdrop {
            background-color: rgba(2, 6, 15, 0.8) !important;
        }

        /* --- 7. HOVER EFFECTS & CARD INTERACTION IN DARK MODE --- */
        html.dark .hover\:shadow-xl:hover,
        html.dark .hover\:shadow-lg:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), 0 0 15px rgba(56, 189, 248, 0.15) !important;
        }
        html.dark .hover\:bg-slate-50:hover,
        html.dark .hover\:bg-slate-100:hover {
            background-color: #1e2d42 !important;
        }
        html.dark a.group:hover {
            border-color: rgba(56, 189, 248, 0.5) !important;
        }

        /* Google Play Button in Dark Mode */
        html.dark a.bg-white.text-slate-800 {
            background-color: #182538 !important;
            color: #f8fafc !important;
            border: 1px solid rgba(56, 189, 248, 0.3) !important;
        }
        html.dark a.bg-white.text-slate-800 .text-slate-500 {
            color: #94a3b8 !important;
        }

        /* Image Diagram White Background Protection in Dark Mode */
        html.dark img.rounded-xl,
        html.dark img.rounded-lg {
            border-color: #27364d !important;
        }

        /* --- 8. FORM INPUTS & SEARCH --- */
        html.dark input[type="text"],
        html.dark input[type="email"],
        html.dark input[type="tel"],
        html.dark input[type="search"],
        html.dark textarea,
        html.dark select {
            background-color: #141c2c !important;
            color: #f1f5f9 !important;
            border-color: #27364d !important;
        }
        html.dark input::placeholder,
        html.dark textarea::placeholder {
            color: #64748b !important;
        }

        /* --- 9. FOOTER HARMONIZATION --- */
        html.dark footer {
            background-color: #060911 !important;
            border-top: 1px solid rgba(56, 189, 248, 0.15) !important;
        }
        html.dark footer .border-primary-800 {
            border-color: #1b2638 !important;
        }
        html.dark footer .text-primary-200 {
            color: #94a3b8 !important;
        }
        html.dark footer .text-primary-300 {
            color: #64748b !important;
        }

        /* --- 10. MODALS, SWEETALERT2, CHATBOT WIDGET --- */
        html.dark #directorModal .bg-white {
            background-color: #141c2c !important;
            border: 1px solid rgba(56, 189, 248, 0.3) !important;
        }
        html.dark .swal2-popup {
            background-color: #141c2c !important;
            color: #e2e8f0 !important;
            border: 1px solid #27364d !important;
        }
        html.dark .swal2-title { color: #f8fafc !important; }
        html.dark .swal2-html-container { color: #cbd5e1 !important; }

        html.dark .chatbot-container,
        html.dark .chatbot-messages-container {
            background-color: #141c2c !important;
            border-color: #27364d !important;
        }
        html.dark .chatbot-input-area {
            background-color: #090d16 !important;
            border-color: #27364d !important;
        }
        html.dark .chatbot-input-area input {
            background-color: #141c2c !important;
            color: #f1f5f9 !important;
        }

        /* Chatbot Widget Specific Dark Overrides */
        html.dark #chatbotWindow {
            background-color: #111a2e !important;
            border-color: #23334d !important;
        }
        html.dark #chatbotMessages {
            background-color: #0d1424 !important;
        }
        html.dark #chatbotWindow .bg-slate-100\/70,
        html.dark #chatbotWindow [class*="bg-slate-100"] {
            background-color: #162238 !important;
            border-color: #23334d !important;
        }
        html.dark #chatbotWindow .text-slate-500 {
            color: #7dd3fc !important; /* sky-300 for crisp, bright label contrast */
        }
        html.dark #chatbotWindow .quick-chip {
            background-color: #1e2d45 !important;
            border-color: #334666 !important;
            color: #f8fafc !important;
        }
        html.dark #chatbotWindow .quick-chip:hover {
            background-color: #1d4ed8 !important;
            border-color: #60a5fa !important;
            color: #ffffff !important;
        }
        html.dark #chatbotForm {
            background-color: #111a2e !important;
            border-color: #23334d !important;
        }
        html.dark #chatbotInput {
            background-color: #18253b !important;
            border-color: #2a3d5c !important;
            color: #f8fafc !important;
        }
        html.dark #chatbotInput::placeholder {
            color: #94a3b8 !important;
        }
    </style>
    <style>
        .fade-img {
            transition: opacity 0.2s ease;
        }

        .nav-dropdown {
            transition: opacity .18s ease, transform .18s ease;
        }

        #mainHeader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            background: transparent;
            transition: background-color .25s ease, box-shadow .25s ease, backdrop-filter .25s ease;
        }

        /* Mobile Navbar Smooth Transisi Logo & Height saat Scroll (Sticky vs Non-Sticky) */
        .mobile-nav-bar {
            height: 76px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .mobile-logo-img {
            height: 3rem; /* 48px pada Non-Sticky */
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #mainHeader.nav-scrolled .mobile-nav-bar {
            height: 58px;
        }
        #mainHeader.nav-scrolled .mobile-logo-img {
            height: 2.25rem; /* 36px pada Sticky (mengecil secara halus) */
        }
        #mainHeader.nav-scrolled {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(6px);
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.08);
        }

        /* Styling Tombol Aksi Mobile (Pengaduan & Cek Tagihan) pada Non-Sticky dan Sticky */
        #mainHeader .mobile-icon {
            color: #ffffff;
        }
        #mainHeader.nav-scrolled .mobile-icon {
            color: #1e293b;
            background-color: rgba(241, 245, 249, 0.9);
            border-color: rgba(226, 232, 240, 0.9);
        }

        /* Search dropdown - posisinya ABSOLUTE, gak dorong elemen lain di flow */
        .search-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: .5rem;
            z-index: 60;
        }
    </style>
    @stack('styles')
    {{-- SweetAlert2 CDN + Custom Theme Perumdam TDA --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-popup {
            border-radius: 1.25rem !important;
            font-family: inherit !important;
            padding: 1.5rem !important;
        }
        .swal2-styled.swal2-confirm {
            background-color: #1d4ed8 !important;
            border-radius: 0.75rem !important;
            padding: 0.6rem 1.5rem !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 12px rgba(29, 78, 216, 0.25) !important;
        }
        .swal2-styled.swal2-cancel {
            background-color: #f1f5f9 !important;
            color: #475569 !important;
            border-radius: 0.75rem !important;
            padding: 0.6rem 1.5rem !important;
            font-weight: 600 !important;
        }
        .swal2-styled.swal2-cancel:hover {
            background-color: #e2e8f0 !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/v2-effects.css') }}">
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

    @include('partials.loading-screen')

    @php $siteLogo = \App\Models\SiteSetting::singleton(); @endphp

    <header id="mainHeader">

        {{-- ===== MOBILE BAR (selalu tampil di layar kecil, gak pernah campur sama versi desktop) ===== --}}
        <div class="lg:hidden flex items-center justify-between mobile-nav-bar px-4">
            <a href="{{ route('home') }}" class="flex items-center z-[1000]">
                @if($siteLogo->logo)
                    <img src="{{ asset('storage/' . $siteLogo->logo) }}" class="mobile-logo-img w-auto object-contain">
                @else
                    <span class="text-3xl">💧</span>
                @endif
            </a>
            
            <div class="flex items-center gap-1.5 z-[1000]">
                {{-- Dark Mode Toggle (Mobile Bar) --}}
                <button type="button" class="darkModeToggleBtn w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-xl bg-white/10 backdrop-blur-md border border-white/20 active:scale-95 transition-all shadow-sm" aria-label="Toggle Dark Mode">
                    <svg class="sun-icon w-5 h-5 text-amber-300 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <svg class="moon-icon w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>

                <button id="mobileMenuBtn" type="button" aria-label="Toggle Menu"
                    class="mobile-icon relative w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-xl bg-white/10 backdrop-blur-md border border-white/20 active:scale-95 transition-all shadow-sm">
                    <div class="w-5 h-4 flex flex-col justify-between items-center relative">
                        <span
                            class="hamburger-line w-5 h-0.5 bg-current rounded-full transition-all duration-300 transform origin-center"></span>
                        <span
                            class="hamburger-line w-3.5 h-0.5 bg-current rounded-full transition-all duration-300 opacity-100"></span>
                        <span
                            class="hamburger-line w-5 h-0.5 bg-current rounded-full transition-all duration-300 transform origin-center"></span>
                    </div>
                </button>
            </div>
        </div>


        {{-- ===== WRAPPER DESKTOP (statis "hidden lg:block", gak pernah disentuh JS) ===== --}}
        <div class="hidden lg:block">

            {{-- ---- MODE REGULAR (non-scrolled) - JS yang toggle 'hidden' di sini ---- --}}
            <div id="navRegular">
                <div class="max-w-7xl mx-auto px-6 lg:px-8 flex items-center justify-end gap-1.5 h-8 text-xs text-white">
                    <a href="{{ route('procurement.index') }}"
                        class="px-3 py-1 rounded hover:bg-white/10 transition">Pengadaan</a>
                    <a href="{{ route('karir.index') }}"
                        class="px-3 py-1 rounded hover:bg-white/10 transition">Karir</a>
                    <div class="relative">
                        <button type="button" onclick="toggleSearch('Regular')"
                            class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/10 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                            </svg>
                        </button>
                        <div id="searchBoxRegular" class="search-dropdown hidden">
                            <form method="GET" action="{{ route('news.index') }}">
                                <input type="text" name="search" placeholder="Cari di Perumdam TDA News..."
                                    class="w-64 px-3 py-2 rounded-lg text-sm text-slate-800 dark:bg-slate-800 dark:text-white border border-transparent dark:border-slate-700 shadow-xl focus:ring-2 focus:ring-primary-400">
                            </form>
                        </div>
                    </div>
                    
                    {{-- Dark Mode Toggle (Desktop Regular) --}}
                    <button type="button" class="darkModeToggleBtn w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/10 text-white transition active:scale-95" aria-label="Toggle Dark Mode">
                        <svg class="sun-icon w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <svg class="moon-icon w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </button>

                    <a href="{{ route('pengaduan-online.index') }}"
                        class="ml-1 inline-flex items-center gap-1 text-xs font-semibold px-3 py-1.5 rounded-full bg-primary-600 text-white hover:bg-primary-700 hover:scale-105 transition-all">
                        Pengaduan Online</a>
                    <a href="https://pelayananperumdamtda.com/mitra/bayar" target="_blank" rel="noopener"
                        class="inline-flex items-center gap-1 text-xs font-semibold px-3 py-1.5 rounded-full bg-emerald-500 text-white hover:bg-emerald-600 hover:scale-105 transition-all">
                        Cek Tagihan</a>
                </div>

                <div class="max-w-7xl mx-auto px-6 lg:px-8 flex items-center justify-between h-20">
                    <a href="{{ route('home') }}" class="flex items-center shrink-0 ml-2 sm:ml-4">
                        @if($siteLogo->logo)
                            <img src="{{ asset('storage/' . $siteLogo->logo) }}" class="h-20 w-auto object-contain">
                        @else
                            <span class="text-4xl text-white">💧</span>
                        @endif
                    </a>
                    <div class="flex items-center gap-1 text-base font-medium text-white -mr-2 sm:-mr-4">
                        <div class="relative group">
                            <a href="{{ route('about-us.index') }}"
                                class="flex items-center gap-1.5 px-4 py-2 rounded-lg hover:bg-white/10 transition">
                                Tentang Kami
                                <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </a>
                            <div
                                class="nav-dropdown absolute left-0 top-full mt-1 w-64 bg-white rounded-xl shadow-xl border py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-1 group-hover:translate-y-0">
                                <a href="{{ route('about-us.index') }}#sekilas"
                                    class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition text-sm">Sekilas
                                    PDAM</a>
                                <a href="{{ route('about-us.index') }}#sejarah"
                                    class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition text-sm">Sejarah</a>
                                <a href="{{ route('about-us.index') }}#visi-misi"
                                    class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition text-sm">Visi
                                    &amp; Misi</a>
                                <a href="{{ route('about-us.index') }}#struktur"
                                    class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition text-sm">Struktur
                                    Organisasi</a>
                                <a href="{{ route('about-us.index') }}#direksi"
                                    class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition text-sm">Jajaran
                                    Direksi &amp; Kuasa Pemilik Modal</a>
                            </div>
                        </div>
                        <div class="relative group">
                            <a href="{{ route('media-informasi.index') }}"
                                class="flex items-center gap-1.5 px-4 py-2 rounded-lg hover:bg-white/10 transition">
                                Media &amp; Informasi
                                <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </a>
                            <div
                                class="nav-dropdown absolute left-0 top-full mt-1 w-60 bg-white rounded-xl shadow-xl border py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-1 group-hover:translate-y-0">
                                <a href="{{ route('news.index') }}"
                                    class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition text-sm">Perumdam
                                    TDA News</a>
                                <a href="{{ route('announcements.index') }}"
                                    class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition text-sm">Pengumuman</a>
                                <a href="{{ route('galleries.index') }}"
                                    class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition text-sm">Galeri</a>
                                <a href="{{ route('publications.index') }}"
                                    class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition text-sm">Publikasi</a>
                            </div>
                        </div>
                        <a href="{{ route('branches.index') }}"
                            class="px-4 py-2 rounded-lg hover:bg-white/10 transition">Hubungi Kami</a>
                    </div>
                </div>
            </div>

            {{-- ---- MODE SCROLLED (sticky, 1 baris) - JS yang toggle 'hidden' di sini ---- --}}
            <div id="navScrolled" class="hidden">
                <div class="max-w-7xl mx-auto px-6 lg:px-8 flex items-center justify-between h-[76px]">
                    <a href="{{ route('home') }}" class="flex items-center shrink-0">
                        @if($siteLogo->logo)
                            <img src="{{ asset('storage/' . $siteLogo->logo) }}" class="h-12 w-auto object-contain">
                        @else
                            <span class="text-3xl">💧</span>
                        @endif
                    </a>
                    <div class="flex items-center gap-1 text-sm font-medium text-slate-800">
                        <div class="relative group">
                            <a href="{{ route('about-us.index') }}"
                                class="flex items-center gap-1 px-3 py-2 rounded-lg hover:bg-slate-100 transition">
                                Tentang Kami
                                <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </a>
                            <div
                                class="nav-dropdown absolute left-0 top-full mt-1 w-64 bg-white rounded-xl shadow-xl border py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-1 group-hover:translate-y-0">
                                <a href="{{ route('about-us.index') }}#sekilas"
                                    class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition">Sekilas
                                    PDAM</a>
                                <a href="{{ route('about-us.index') }}#sejarah"
                                    class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition">Sejarah</a>
                                <a href="{{ route('about-us.index') }}#visi-misi"
                                    class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition">Visi
                                    &amp; Misi</a>
                                <a href="{{ route('about-us.index') }}#struktur"
                                    class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition">Struktur
                                    Organisasi</a>
                                <a href="{{ route('about-us.index') }}#direksi"
                                    class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition">Jajaran
                                    Direksi &amp; Kuasa Pemilik Modal</a>
                            </div>
                        </div>
                        <div class="relative group">
                            <a href="{{ route('media-informasi.index') }}"
                                class="flex items-center gap-1 px-3 py-2 rounded-lg hover:bg-slate-100 transition">
                                Media &amp; Informasi
                                <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </a>
                            <div
                                class="nav-dropdown absolute left-0 top-full mt-1 w-60 bg-white rounded-xl shadow-xl border py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-1 group-hover:translate-y-0">
                                <a href="{{ route('news.index') }}"
                                    class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition">Perumdam
                                    TDA News</a>
                                <a href="{{ route('announcements.index') }}"
                                    class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition">Pengumuman</a>
                                <a href="{{ route('galleries.index') }}"
                                    class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition">Galeri</a>
                                <a href="{{ route('publications.index') }}"
                                    class="block px-4 py-2.5 text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition">Publikasi</a>
                            </div>
                        </div>
                        <a href="{{ route('procurement.index') }}"
                            class="px-3 py-2 rounded-lg hover:bg-slate-100 transition">Pengadaan</a>
                        <a href="{{ route('branches.index') }}"
                            class="px-3 py-2 rounded-lg hover:bg-slate-100 transition">Hubungi Kami</a>
                        <a href="{{ route('karir.index') }}"
                            class="px-3 py-2 rounded-lg hover:bg-slate-100 transition">Karir</a>
                        <div class="relative">
                            <button type="button" onclick="toggleSearch('Scrolled')"
                                class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-slate-100 transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                                </svg>
                            </button>
                            <div id="searchBoxScrolled" class="search-dropdown hidden">
                                <form method="GET" action="{{ route('news.index') }}">
                                    <input type="text" name="search" placeholder="Cari di Perumdam TDA News..."
                                        class="w-64 px-3 py-2 rounded-lg text-sm border shadow-xl focus:ring-2 focus:ring-primary-400">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        {{-- Dark Mode Toggle (Desktop Scrolled) --}}
                        <button type="button" class="darkModeToggleBtn w-9 h-9 flex items-center justify-center rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 transition active:scale-95" aria-label="Toggle Dark Mode">
                            <svg class="sun-icon w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <svg class="moon-icon w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        </button>

                        <a href="{{ route('pengaduan-online.index') }}"
                            class="inline-flex items-center gap-1.5 text-sm font-semibold px-4 py-2 rounded-full bg-primary-600 text-white hover:bg-primary-700 hover:shadow-lg hover:scale-105 transition-all">
                            Pengaduan Online</a>
                        <a href="https://pelayananperumdamtda.com/mitra/bayar" target="_blank" rel="noopener"
                            class="inline-flex items-center gap-1.5 text-sm font-semibold px-4 py-2 rounded-full bg-emerald-500 text-white hover:bg-emerald-600 hover:shadow-lg hover:scale-105 transition-all">
                            Cek Tagihan</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- ===== MOBILE OFF-CANVAS MENU DRAWER (outside header for correct z-index stacking) ===== --}}
    <!-- Overlay Backdrop -->
    <div id="mobileBackdrop"
        class="fixed inset-0 bg-slate-950/60 backdrop-blur-md z-[998] lg:hidden opacity-0 pointer-events-none transition-opacity duration-300">
    </div>

    <!-- Drawer Panel -->
    <div id="mobileDrawer"
        class="fixed top-0 right-0 bottom-0 w-[88%] max-w-sm bg-white/95 backdrop-blur-xl z-[999] lg:hidden shadow-2xl transition-all duration-300 ease-out transform translate-x-full flex flex-col justify-between overflow-y-auto">
        <div class="px-5 pt-5 pb-6 space-y-5">
            <!-- Mobile Drawer Header with Close (X) Button -->
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    @if($siteLogo->logo)
                        <img src="{{ asset('storage/' . $siteLogo->logo) }}" class="h-9 w-auto object-contain">
                    @else
                        <span class="text-2xl">💧</span>
                    @endif
                    <span class="font-bold text-sm text-slate-800"></span>
                </a>
                <button id="mobileDrawerCloseBtn" type="button" aria-label="Tutup Menu"
                    class="w-9 h-9 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 active:scale-95 transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Search Bar -->
            <form method="GET" action="{{ route('news.index') }}" class="relative">
                <input type="text" name="search" placeholder="Cari informasi..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm bg-slate-100/80 border border-slate-200/80 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 transition-all">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                </svg>
            </form>

            <nav class="space-y-1.5 font-medium text-slate-700">
                <!-- Accordion 1: Tentang Kami -->
                <div class="rounded-xl border border-slate-100 bg-slate-50/50 overflow-hidden">
                    <button type="button" onclick="toggleMobileAccordion('about')"
                        class="w-full flex items-center justify-between px-4 py-3 text-left font-semibold text-slate-800 hover:bg-slate-100/60 transition">
                        <span class="flex items-center gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-primary-600"></span>
                            Tentang Kami
                        </span>
                        <svg id="accordionIcon-about" class="w-4 h-4 text-slate-400 transition-transform duration-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="accordionContent-about"
                        class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-white/70">
                        <div class="px-4 py-2 space-y-1 text-sm text-slate-600 border-t border-slate-100">
                            <a href="{{ route('about-us.index') }}"
                                class="block px-3 py-2 rounded-lg hover:bg-primary-50 hover:text-primary-700 font-medium text-primary-600 transition">Utama
                                Tentang Kami →</a>
                            <a href="{{ route('about-us.index') }}#sekilas"
                                class="block px-3 py-1.5 rounded-lg hover:bg-slate-100 transition">Sekilas PDAM</a>
                            <a href="{{ route('about-us.index') }}#sejarah"
                                class="block px-3 py-1.5 rounded-lg hover:bg-slate-100 transition">Sejarah</a>
                            <a href="{{ route('about-us.index') }}#visi-misi"
                                class="block px-3 py-1.5 rounded-lg hover:bg-slate-100 transition">Visi &amp; Misi</a>
                            <a href="{{ route('about-us.index') }}#struktur"
                                class="block px-3 py-1.5 rounded-lg hover:bg-slate-100 transition">Struktur
                                Organisasi</a>
                            <a href="{{ route('about-us.index') }}#direksi"
                                class="block px-3 py-1.5 rounded-lg hover:bg-slate-100 transition">Jajaran Direksi &amp;
                                Kuasa Pemilik Modal</a>
                        </div>
                    </div>
                </div>

                <!-- Accordion 2: Media & Informasi -->
                <div class="rounded-xl border border-slate-100 bg-slate-50/50 overflow-hidden">
                    <button type="button" onclick="toggleMobileAccordion('media')"
                        class="w-full flex items-center justify-between px-4 py-3 text-left font-semibold text-slate-800 hover:bg-slate-100/60 transition">
                        <span class="flex items-center gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Media &amp; Informasi
                        </span>
                        <svg id="accordionIcon-media" class="w-4 h-4 text-slate-400 transition-transform duration-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="accordionContent-media"
                        class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-white/70">
                        <div class="px-4 py-2 space-y-1 text-sm text-slate-600 border-t border-slate-100">
                            <a href="{{ route('media-informasi.index') }}"
                                class="block px-3 py-2 rounded-lg hover:bg-emerald-50 hover:text-emerald-700 font-medium text-emerald-600 transition">Utama
                                Media &amp; Informasi →</a>
                            <a href="{{ route('news.index') }}"
                                class="block px-3 py-1.5 rounded-lg hover:bg-slate-100 transition">Perumdam TDA News</a>
                            <a href="{{ route('announcements.index') }}"
                                class="block px-3 py-1.5 rounded-lg hover:bg-slate-100 transition">Pengumuman</a>
                            <a href="{{ route('galleries.index') }}"
                                class="block px-3 py-1.5 rounded-lg hover:bg-slate-100 transition">Galeri</a>
                            <a href="{{ route('publications.index') }}"
                                class="block px-3 py-1.5 rounded-lg hover:bg-slate-100 transition">Publikasi</a>
                        </div>
                    </div>
                </div>

                <!-- Single Navigation Links -->
                <a href="{{ route('procurement.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-100 text-slate-800 font-semibold transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Pengadaan
                </a>
                <a href="{{ route('branches.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-100 text-slate-800 font-semibold transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Hubungi Kami
                </a>
                <a href="{{ route('karir.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-100 text-slate-800 font-semibold transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Karir
                </a>
            </nav>
        </div>

        <!-- Action Call-to-Actions in Footer Drawer -->
        <div class="p-5 border-t border-slate-100 bg-slate-50/80 dark:bg-slate-900/80 dark:border-slate-800 space-y-2.5">
            <a href="{{ route('pengaduan-online.index') }}"
                class="flex items-center justify-center gap-2 text-sm font-semibold py-3 px-4 rounded-xl bg-primary-600 hover:bg-primary-700 text-white shadow-md shadow-primary-600/20 active:scale-[0.98] transition-all">
                <svg class="w-5 h-5 text-white shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c.41 0 .789-.244.945-.623l.775-1.938a1.5 1.5 0 012.796.885v10.354a1.5 1.5 0 01-2.796.885l-.775-1.938a1.002 1.002 0 00-.945-.623H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                <span>Pengaduan Online</span>
            </a>
            <a href="https://pelayananperumdamtda.com/mitra/bayar" target="_blank" rel="noopener"
                class="flex items-center justify-center gap-2 text-sm font-semibold py-3 px-4 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 text-white shadow-md shadow-emerald-500/20 active:scale-[0.98] transition-all">
                <svg class="w-5 h-5 text-white shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <span>Cek Tagihan Air</span>
            </a>
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    <footer class="bg-primary-900 text-primary-100 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid md:grid-cols-4 gap-8 text-sm">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    @if($siteLogo->logo)
                        <img src="{{ asset('storage/' . $siteLogo->logo) }}" class="h-12 w-auto object-contain">
                    @else
                        <span class="font-bold text-white text-lg"> PERUMDAM Tirta Darma Ayu</span>
                    @endif
                </div>
                <p class="text-primary-200">Badan Usaha Milik Daerah penyedia air bersih untuk masyarakat Kabupaten
                    Indramayu.</p>

                <div class="flex items-center gap-3 mt-4">
                    <a href="https://www.instagram.com/perumdamtda_indramayu" target="_blank" rel="noopener"
                        aria-label="Instagram"
                        class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                        </svg>
                    </a>
                    <a href="https://www.facebook.com/perumdamtdaindramayu" target="_blank" rel="noopener"
                        aria-label="Facebook"
                        class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.988h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                        </svg>
                    </a>
                    <a href="https://youtube.com/@humastirtadarmaayu1452" target="_blank" rel="noopener"
                        aria-label="YouTube"
                        class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                        </svg>
                    </a>
                </div>
            </div>
            <div>
                <div class="font-semibold text-white mb-2">Tentang Kami</div>
                <ul class="space-y-1 text-primary-200">
                    <li><a href="{{ route('about-us.index') }}" class="hover:text-white transition">Profil
                            Perusahaan</a></li>
                    <li><a href="{{ route('news.index') }}" class="hover:text-white transition">Perumdam TDA News</a>
                    </li>
                    <li><a href="{{ route('publications.index') }}" class="hover:text-white transition">Dokumen &amp;
                            Publikasi</a></li>
                </ul>
            </div>
            <div>
                <div class="font-semibold text-white mb-2">Layanan</div>
                <ul class="space-y-1 text-primary-200">
                    <li><a href="{{ route('pengaduan-online.index') }}" class="hover:text-white transition">Pengaduan
                            Online</a></li>
                    <li><a href="https://pelayananperumdamtda.com/mitra/bayar" target="_blank" rel="noopener"
                            class="hover:text-white transition">Cek Tagihan</a></li>
                    <li><a href="{{ route('branches.index') }}" class="hover:text-white transition">Peta Cabang
                            Layanan</a></li>
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
            (function () {
                const mobileMenuBtn = document.getElementById('mobileMenuBtn');
                const mobileDrawerCloseBtn = document.getElementById('mobileDrawerCloseBtn');
                const mobileDrawer = document.getElementById('mobileDrawer');
                const mobileBackdrop = document.getElementById('mobileBackdrop');
                const lines = mobileMenuBtn?.querySelectorAll('.hamburger-line');
                let isOpen = false;

                function toggleMenu() {
                    isOpen = !isOpen;
                    if (isOpen) {
                        // Open Drawer
                        mobileDrawer?.classList.remove('translate-x-full');
                        mobileDrawer?.classList.add('translate-x-0');
                        mobileBackdrop?.classList.remove('opacity-0', 'pointer-events-none');
                        mobileBackdrop?.classList.add('opacity-100');
                        document.body.classList.add('overflow-hidden');

                        // Morph Hamburger to X
                        if (lines && lines.length === 3) {
                            lines[0].classList.add('rotate-45', 'translate-y-[7px]');
                            lines[1].classList.add('opacity-0', 'scale-0');
                            lines[2].classList.add('-rotate-45', '-translate-y-[7px]');
                        }
                    } else {
                        // Close Drawer
                        mobileDrawer?.classList.remove('translate-x-0');
                        mobileDrawer?.classList.add('translate-x-full');
                        mobileBackdrop?.classList.remove('opacity-100');
                        mobileBackdrop?.classList.add('opacity-0', 'pointer-events-none');
                        document.body.classList.remove('overflow-hidden');

                        // Morph X back to Hamburger
                        if (lines && lines.length === 3) {
                            lines[0].classList.remove('rotate-45', 'translate-y-[7px]');
                            lines[1].classList.remove('opacity-0', 'scale-0');
                            lines[2].classList.remove('-rotate-45', '-translate-y-[7px]');
                        }
                    }
                }

                mobileMenuBtn?.addEventListener('click', toggleMenu);
                mobileDrawerCloseBtn?.addEventListener('click', toggleMenu);
                mobileBackdrop?.addEventListener('click', toggleMenu);

                // Close menu on ESC key press
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && isOpen) toggleMenu();
                });
            })();

        // Accordion Toggle for Mobile
        function toggleMobileAccordion(key) {
            const content = document.getElementById('accordionContent-' + key);
            const icon = document.getElementById('accordionIcon-' + key);

            if (!content) return;
            if (content.style.maxHeight && content.style.maxHeight !== '0px') {
                content.style.maxHeight = '0px';
                if (icon) icon.classList.remove('rotate-180');
            } else {
                content.style.maxHeight = content.scrollHeight + 'px';
                if (icon) icon.classList.add('rotate-180');
            }
        }

        (function () {
            const header = document.getElementById('mainHeader');
            const navRegular = document.getElementById('navRegular');
            const navScrolled = document.getElementById('navScrolled');

            function updateNav() {
                const scrolled = window.scrollY > 40;
                if (header) header.classList.toggle('nav-scrolled', scrolled);
                if (navRegular) navRegular.classList.toggle('hidden', scrolled);
                if (navScrolled) navScrolled.classList.toggle('hidden', !scrolled);
            }
            window.addEventListener('scroll', updateNav, { passive: true });
            updateNav();
        })();

        function toggleSearch(which) {
            document.getElementById('searchBox' + which).classList.toggle('hidden');
        }

        // Klik di luar search box -> nutup otomatis
        document.addEventListener('click', function (e) {
            ['Regular', 'Scrolled'].forEach(which => {
                const box = document.getElementById('searchBox' + which);
                if (!box || box.classList.contains('hidden')) return;
                if (!box.parentElement.contains(e.target)) box.classList.add('hidden');
            });
        });

        // Logika Toggle Dark Mode & Sinkronisasi Preferensi Tema
        (function() {
            const toggleBtns = document.querySelectorAll('.darkModeToggleBtn');
            
            function syncIcons(isDark) {
                toggleBtns.forEach(btn => {
                    const sun = btn.querySelector('.sun-icon');
                    const moon = btn.querySelector('.moon-icon');
                    if (isDark) {
                        sun?.classList.remove('hidden');
                        moon?.classList.add('hidden');
                    } else {
                        sun?.classList.add('hidden');
                        moon?.classList.remove('hidden');
                    }
                });
            }

            function setDarkMode(isDark) {
                if (isDark) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }
                syncIcons(isDark);
            }

            // Sync awal UI sesuai class 'dark' di <html>
            syncIcons(document.documentElement.classList.contains('dark'));

            toggleBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const isCurrentlyDark = document.documentElement.classList.contains('dark');
                    setDarkMode(!isCurrentlyDark);
                });
            });

            // Respon otomatis terhadap perubahan tema OS pengguna (System Preference)
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
                if (!localStorage.getItem('theme')) {
                    setDarkMode(e.matches);
                }
            });
        })();
    </script>

    {{-- ============ TAMBAHAN BARU: transisi halaman + reveal animation v2 ============ --}}
    <script src="{{ asset('js/v2-reveal.js') }}"></script>

    @stack('scripts')
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</body>

</html>