@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
{{-- Greeting --}}
<div class="mb-6">
    <h2 class="text-xl sm:text-2xl font-bold text-slate-800">
        Selamat Datang, {{ auth()->user()->name }} 👋
    </h2>
    <p class="text-slate-500 text-sm mt-1">Kelola dan pantau konten website PERUMDAM Tirta Darma Ayu.</p>
</div>

{{-- Stat Cards --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4 mb-8">
    {{-- News --}}
    <a href="{{ route('admin.news.index') }}" class="stat-card admin-card p-4 sm:p-5 group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition">
                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
            </div>
            <svg class="w-4 h-4 text-slate-300 group-hover:text-slate-400 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        </div>
        <div class="text-2xl sm:text-3xl font-extrabold text-slate-800">{{ $stats['news'] }}</div>
        <div class="text-slate-500 text-xs sm:text-sm mt-0.5">Berita</div>
    </a>

    {{-- Announcements --}}
    <a href="{{ route('admin.announcements.index') }}" class="stat-card admin-card p-4 sm:p-5 group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center group-hover:bg-amber-100 transition">
                <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46"/></svg>
            </div>
            <svg class="w-4 h-4 text-slate-300 group-hover:text-slate-400 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        </div>
        <div class="text-2xl sm:text-3xl font-extrabold text-slate-800">{{ $stats['announcements'] }}</div>
        <div class="text-slate-500 text-xs sm:text-sm mt-0.5">Pengumuman</div>
    </a>

    {{-- Galleries --}}
    <a href="{{ route('admin.galleries.index') }}" class="stat-card admin-card p-4 sm:p-5 group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center group-hover:bg-violet-100 transition">
                <svg class="w-5 h-5 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v13.5a1.5 1.5 0 001.5 1.5zm7.5-12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
            </div>
            <svg class="w-4 h-4 text-slate-300 group-hover:text-slate-400 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        </div>
        <div class="text-2xl sm:text-3xl font-extrabold text-slate-800">{{ $stats['galleries'] }}</div>
        <div class="text-slate-500 text-xs sm:text-sm mt-0.5">Album Galeri</div>
    </a>

    {{-- Documents --}}
    <a href="{{ route('admin.publications.index') }}" class="stat-card admin-card p-4 sm:p-5 group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center group-hover:bg-emerald-100 transition">
                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            </div>
            <svg class="w-4 h-4 text-slate-300 group-hover:text-slate-400 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        </div>
        <div class="text-2xl sm:text-3xl font-extrabold text-slate-800">{{ $stats['documents'] }}</div>
        <div class="text-slate-500 text-xs sm:text-sm mt-0.5">Dokumen Publikasi</div>
    </a>

    {{-- Branches --}}
    <a href="{{ route('admin.branches.index') }}" class="stat-card admin-card p-4 sm:p-5 group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center group-hover:bg-rose-100 transition">
                <svg class="w-5 h-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
            </div>
            <svg class="w-4 h-4 text-slate-300 group-hover:text-slate-400 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        </div>
        <div class="text-2xl sm:text-3xl font-extrabold text-slate-800">{{ $stats['branches'] }}</div>
        <div class="text-slate-500 text-xs sm:text-sm mt-0.5">Cabang & IPA</div>
    </a>
</div>

{{-- Charts Row --}}
<div class="grid lg:grid-cols-3 gap-4 sm:gap-5 mb-8">
    {{-- Bar Chart: Monthly Content Activity --}}
    <div class="lg:col-span-2 admin-card p-5 sm:p-6">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="font-bold text-slate-800">Aktivitas Konten</h3>
                <p class="text-xs text-slate-400 mt-0.5">Berita & Pengumuman 6 bulan terakhir</p>
            </div>
            <div class="flex items-center gap-3 text-xs">
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>Berita</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>Pengumuman</span>
            </div>
        </div>
        <div style="position: relative; height: 240px;">
            <canvas id="activityChart"></canvas>
        </div>
    </div>

    {{-- Donut Chart: Branch Distribution --}}
    <div class="admin-card p-5 sm:p-6">
        <div class="mb-5">
            <h3 class="font-bold text-slate-800">Distribusi Lokasi</h3>
            <p class="text-xs text-slate-400 mt-0.5">Cabang/Unit vs IPA</p>
        </div>
        <div class="flex items-center justify-center" style="height: 180px;">
            <canvas id="branchChart"></canvas>
        </div>
        <div class="flex justify-center gap-5 mt-4 text-xs">
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>Cabang/Unit ({{ $branchStats['cabang'] }})</span>
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>IPA ({{ $branchStats['ipa'] }})</span>
        </div>
    </div>
</div>

{{-- Bottom Row: Recent News + Quick Stats --}}
<div class="grid lg:grid-cols-5 gap-4 sm:gap-5">
    {{-- Recent News --}}
    <div class="lg:col-span-3 admin-card">
        <div class="flex items-center justify-between p-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">Berita Terbaru</h3>
            <a href="{{ route('admin.news.index') }}" class="text-xs font-medium text-primary-600 hover:text-primary-700 transition">Lihat Semua →</a>
        </div>
        <div class="divide-y divide-slate-50">
            @forelse($recentNews as $news)
                <a href="{{ route('admin.news.edit', $news) }}" class="flex items-center gap-3 p-4 hover:bg-slate-50 transition group">
                    <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center shrink-0 group-hover:bg-blue-100 transition">
                        <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-sm font-medium text-slate-700 truncate group-hover:text-primary-600 transition">{{ $news->title }}</div>
                        <div class="text-[11px] text-slate-400 mt-0.5">{{ $news->created_at->diffForHumans() }}</div>
                    </div>
                    <svg class="w-4 h-4 text-slate-300 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
            @empty
                <div class="p-6 text-center text-slate-400 text-sm">Belum ada berita.</div>
            @endforelse
        </div>
    </div>

    {{-- Quick Access --}}
    <div class="lg:col-span-2 admin-card p-5 sm:p-6">
        <h3 class="font-bold text-slate-800 mb-4">Akses Cepat</h3>
        <div class="space-y-2">
            <a href="{{ route('admin.news.create') }}" class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:border-primary-200 hover:bg-primary-50/50 transition group">
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition">
                    <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                </div>
                <span class="text-sm font-medium text-slate-600 group-hover:text-primary-700">Tulis Berita Baru</span>
            </a>
            <a href="{{ route('admin.announcements.create') }}" class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:border-amber-200 hover:bg-amber-50/50 transition group">
                <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center group-hover:bg-amber-100 transition">
                    <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                </div>
                <span class="text-sm font-medium text-slate-600 group-hover:text-amber-700">Buat Pengumuman</span>
            </a>
            <a href="{{ route('admin.branches.create') }}" class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50/50 transition group">
                <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center group-hover:bg-emerald-100 transition">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                </div>
                <span class="text-sm font-medium text-slate-600 group-hover:text-emerald-700">Tambah Lokasi Cabang</span>
            </a>
            <a href="{{ route('admin.header-slides.index') }}" class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:border-violet-200 hover:bg-violet-50/50 transition group">
                <div class="w-8 h-8 rounded-lg bg-violet-50 flex items-center justify-center group-hover:bg-violet-100 transition">
                    <svg class="w-4 h-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909"/></svg>
                </div>
                <span class="text-sm font-medium text-slate-600 group-hover:text-violet-700">Kelola Poster Header</span>
            </a>
        </div>

        {{-- Content Summary --}}
        <div class="mt-5 pt-4 border-t border-slate-100">
            <div class="flex items-center justify-between text-sm mb-2">
                <span class="text-slate-500">Total Foto</span>
                <span class="font-bold text-slate-700">{{ $stats['photos'] ?? 0 }}</span>
            </div>
            <div class="flex items-center justify-between text-sm mb-2">
                <span class="text-slate-500">Data Pengadaan</span>
                <span class="font-bold text-slate-700">{{ $stats['procurement'] ?? 0 }}</span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const monthlyData = @json($monthlyData);

    // ── Bar Chart: Monthly Activity ──
    new Chart(document.getElementById('activityChart'), {
        type: 'bar',
        data: {
            labels: monthlyData.map(d => d.label),
            datasets: [
                {
                    label: 'Berita',
                    data: monthlyData.map(d => d.news),
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderRadius: 6,
                    borderSkipped: false,
                    barPercentage: 0.5,
                    categoryPercentage: 0.6,
                },
                {
                    label: 'Pengumuman',
                    data: monthlyData.map(d => d.announcements),
                    backgroundColor: 'rgba(251, 191, 36, 0.8)',
                    borderRadius: 6,
                    borderSkipped: false,
                    barPercentage: 0.5,
                    categoryPercentage: 0.6,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleFont: { family: 'Inter', size: 12 },
                    bodyFont: { family: 'Inter', size: 11 },
                    cornerRadius: 8,
                    padding: 10,
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { family: 'Inter', size: 11 }, color: '#94a3b8' },
                    border: { display: false },
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        font: { family: 'Inter', size: 11 },
                        color: '#94a3b8',
                        stepSize: 1,
                        callback: v => Number.isInteger(v) ? v : null,
                    },
                    border: { display: false },
                }
            }
        }
    });

    // ── Donut Chart: Branch Distribution ──
    new Chart(document.getElementById('branchChart'), {
        type: 'doughnut',
        data: {
            labels: ['Cabang/Unit', 'IPA'],
            datasets: [{
                data: [{{ $branchStats['cabang'] }}, {{ $branchStats['ipa'] }}],
                backgroundColor: ['rgba(59, 130, 246, 0.85)', 'rgba(52, 211, 153, 0.85)'],
                borderWidth: 0,
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleFont: { family: 'Inter', size: 12 },
                    bodyFont: { family: 'Inter', size: 11 },
                    cornerRadius: 8,
                    padding: 10,
                }
            }
        }
    });
});
</script>
@endpush
