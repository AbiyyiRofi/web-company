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
<div x-data="{ sidebarOpen: false }" class="min-h-screen flex flex-col md:flex-row bg-slate-100 text-slate-800">
    <!-- Backdrop for mobile -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false" 
         class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm md:hidden" 
         style="display: none;"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
           class="fixed inset-y-0 left-0 z-50 w-72 bg-primary-900 text-white flex flex-col transition-transform duration-300 ease-in-out md:static md:z-auto shrink-0 shadow-xl md:shadow-none">
        <div class="p-5 border-b border-primary-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                @if($siteLogo->logo)
                    <img src="{{ asset('storage/'.$siteLogo->logo) }}" class="h-9 w-auto object-contain">
                @else
                    <span class="text-xl">💧</span>
                @endif
                <div>
                    <div class="font-bold text-sm leading-tight">Portal Internal</div>
                    <div class="text-xs text-primary-300 truncate max-w-[140px]">Admin — {{ auth()->user()->name }}</div>
                </div>
            </div>
            <!-- Close button for mobile -->
            <button @click="sidebarOpen = false" class="md:hidden text-primary-300 hover:text-white p-1 rounded-lg">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
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
                    <a href="{{ route('admin.history.index') }}" class="block px-3 py-1.5 rounded-lg hover:bg-primary-800 text-primary-200 {{ request()->routeIs('admin.history.*') ? 'bg-primary-800 text-white' : '' }}">Sejarah (Per Tahun)</a>
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

    <!-- Main Content Container -->
    <div class="flex-1 flex flex-col min-w-0">
        <header class="bg-white border-b px-4 sm:px-6 py-4 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <!-- Hamburger button for mobile -->
                <button @click="sidebarOpen = true" class="md:hidden text-slate-600 hover:text-slate-900 p-1.5 rounded-lg border border-slate-200">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-base sm:text-lg font-semibold truncate">@yield('title', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-2 text-xs sm:text-sm text-slate-500">
                <span class="hidden sm:inline">Portal Admin</span>
            </div>
        </header>
        <main class="flex-1 p-4 sm:p-6 overflow-x-auto">
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

<!-- SweetAlert2 CDN & Global Auto-Confirm Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .swal2-popup {
        border-radius: 1.25rem !important;
        font-family: inherit !important;
        padding: 1.5rem !important;
    }
    .swal2-styled.swal2-confirm {
        border-radius: 0.75rem !important;
        padding: 0.6rem 1.5rem !important;
        font-weight: 600 !important;
    }
    .swal2-styled.swal2-cancel {
        background-color: #f1f5f9 !important;
        color: #475569 !important;
        border-radius: 0.75rem !important;
        padding: 0.6rem 1.5rem !important;
        font-weight: 600 !important;
    }
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
                    confirmButtonColor: '#1d4ed8',
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

<!-- Alpine JS for mobile menu interactivity -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@include('partials.lightbox')
<script src="{{ asset('js/multi-image-uploader.js') }}"></script>
@stack('scripts')
</body>
</html>
