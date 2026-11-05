@extends('layouts.app')
@section('title', 'Tentang Kami')

@section('content')

    <section class="relative h-72 sm:h-80 bg-slate-900 overflow-hidden">
        <img src="{{ $content->header_image ? asset('storage/' . $content->header_image) : 'https://placehold.co/1600x600/1e3a8a/white?text=Tentang+Kami' }}"
            class="w-full h-full object-cover brightness-[0.45] blur-[1px]">
        <div class="absolute inset-0 flex items-end">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 w-full">
                @include('partials.breadcrumb', ['currentPage' => 'Tentang Kami'])
                <h1 class="text-3xl sm:text-4xl font-bold text-white">Tentang Kami</h1>
                @if($content->header_caption)
                    <p class="text-primary-100 mt-2 max-w-2xl">{{ $content->header_caption }}</p>
                @endif
            </div>
        </div>
    </section>

    <section id="sekilas" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 scroll-mt-20">
        <h2 class="text-2xl sm:text-3xl font-bold text-center mb-8 reveal">Sekilas PDAM</h2>
        <div class="prose max-w-none text-slate-600 leading-relaxed text-justify reveal whitespace-pre-line">
            {!! $content->sekilas_text ? Str::inlineMarkdown(e($content->sekilas_text)) : '<p class="text-slate-400 italic">Belum ada konten.</p>' !!}
        </div>
    </section>

    {{-- ===== SEJARAH KEPEMIMPINAN (COVERFLOW 3D PERSPECTIVE SLIDER) ===== --}}
    @if($leadershipHistories->count())
    <section id="sejarah-kepemimpinan" class="py-16 sm:py-20 bg-white overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-8">
            <span class="text-xs sm:text-sm font-bold uppercase tracking-widest text-sky-500">KEPEMIMPINAN PERUMDAM TDA</span>
            <h2 class="text-3xl sm:text-5xl font-black text-slate-900 mt-1 tracking-tight">Sejarah Direksi Masa Jabatan</h2>
            <p class="text-slate-500 text-sm sm:text-base mt-2">Jejak kepemimpinan Direktur Perumdam Tirta Darma Ayu dari periode ke periode</p>
        </div>

        {{-- 3D Coverflow Container --}}
        <div class="relative w-full max-w-7xl mx-auto min-h-[460px] sm:min-h-[520px] flex flex-col items-center justify-center overflow-hidden py-4 select-none">
            {{-- Slider Track --}}
            <div id="leadershipCoverflowTrack" class="relative w-full h-[360px] sm:h-[420px] flex items-center justify-center">
                {{-- Prev / Next Navigation Controls Overlaying the center card edges --}}
                <button type="button" id="leadershipPrevBtn" aria-label="Sebelumnya"
                    class="absolute z-40 w-9 h-9 sm:w-11 sm:h-11 rounded-full bg-black hover:bg-slate-800 text-white flex items-center justify-center shadow-2xl transition-all hover:scale-110 active:scale-95 cursor-pointer border border-white/20">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>

                <button type="button" id="leadershipNextBtn" aria-label="Berikutnya"
                    class="absolute z-40 w-9 h-9 sm:w-11 sm:h-11 rounded-full bg-black hover:bg-slate-800 text-white flex items-center justify-center shadow-2xl transition-all hover:scale-110 active:scale-95 cursor-pointer border border-white/20">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>

                @foreach($leadershipHistories as $index => $item)
                    <div class="leadership-coverflow-card absolute top-0 transition-all duration-500 ease-out cursor-pointer flex flex-col items-center"
                        data-index="{{ $index }}"
                        data-name="{{ $item->name }}"
                        data-period="{{ $item->period }}"
                        data-position="{{ $item->position ?: 'Direktur Utama' }}">
                        <div class="card-img-wrapper w-[170px] h-[230px] sm:w-[220px] sm:h-[300px] md:w-[260px] md:h-[350px] rounded-none overflow-hidden bg-slate-200 border border-slate-300 shadow-xl transition-all duration-500">
                            <img src="{{ $item->photo ? asset('storage/' . $item->photo) : 'https://placehold.co/400x500/e2e8f0/64748b?text=Foto' }}"
                                class="w-full h-full object-cover" loading="lazy" decoding="async">
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Active Director Info Text Below Center Card --}}
            <div class="mt-6 text-center z-30 transition-all duration-300">
                <h3 id="activeDirectorName" class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight uppercase"></h3>
                <p id="activeDirectorPeriod" class="text-slate-900 font-bold text-lg sm:text-2xl mt-1"></p>
                <p id="activeDirectorPosition" class="text-sky-600 font-semibold text-xs sm:text-sm mt-0.5"></p>
            </div>
        </div>
    </section>
    @endif

    {{-- ===== SEJARAH (PER TAMBAHAN ADMIN - PERTAMINA STYLE TIMELINE SLIDER) ===== --}}
    <section id="sejarah" class="relative py-16 sm:py-24 overflow-hidden scroll-mt-20 min-h-[500px] sm:min-h-[580px] flex flex-col justify-between bg-slate-900">
        {{-- Background Image dari Inputan Admin (Dipertahankan sesuai instruksi) --}}
        @if($content->sejarah_bg_image)
            <img src="{{ asset('storage/' . $content->sejarah_bg_image) }}"
                class="absolute inset-0 w-full h-full object-cover brightness-[0.35] blur-[0.5px]">
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-primary-950 to-slate-900"></div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-slate-950/60"></div>

        {{-- Top Section Header --}}
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center pt-4 z-10 w-full">
            <span class="text-xs sm:text-sm font-semibold uppercase tracking-widest text-sky-400">Jejak Langkah</span>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-white mt-1">Sejarah Perusahaan</h2>
        </div>

        {{-- Main Slide Content Container --}}
        <div id="historySlider" class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 z-10 w-full py-8 my-auto">
            @forelse($historyItems as $i => $history)
                <div class="history-slide transition-all duration-500 {{ $i === 0 ? 'block opacity-100' : 'hidden opacity-0' }}"
                    data-year="{{ $history->year }}" data-duration="8000">
                    <div class="max-w-3xl mx-auto text-left sm:text-left space-y-4">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white font-bold text-sm sm:text-base">
                            <span class="w-2 h-2 rounded-full bg-sky-400 animate-pulse"></span>
                            <span>Tahun {{ $history->year }}</span>
                        </div>
                        <h3 class="text-2xl sm:text-4xl font-bold text-white leading-tight drop-shadow-md">
                            {{ $history->title ?: 'Perjalanan Sejarah ' . $history->year }}
                        </h3>
                        <p class="text-slate-200 text-sm sm:text-lg leading-relaxed sm:leading-loose whitespace-pre-line drop-shadow">
                            {!! Str::inlineMarkdown(e($history->content)) !!}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center text-white/60 py-12 italic">
                    Belum ada data sejarah yang dimasukkan. Admin dapat menginput sejarah melalui Portal Admin.
                </div>
            @endforelse
        </div>

        {{-- Bottom Timeline Navigation Buttons (Dinamis Sesuai Inputan Admin) --}}
        <div class="relative z-10 pb-4 w-full">
            <div id="historyLabels"></div>
        </div>
    </section>
    <script src="{{ asset('js/history-slider.js') }}"></script>

    <section id="visi-misi" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 scroll-mt-20">
        <h2 class="text-2xl sm:text-3xl font-bold text-center mb-8 reveal">Visi &amp; Misi</h2>
        <div class="grid sm:grid-cols-2 gap-6 items-start">
            <div class="bg-primary-100 rounded-2xl p-8 hover:shadow-lg transition reveal">
                <div class="text-primary-600 font-bold text-lg mb-3">Visi</div>
                <div class="text-slate-600 leading-relaxed whitespace-pre-line">
                    {!! $content->visi_text ? Str::inlineMarkdown(e($content->visi_text)) : '<span class="text-slate-400 italic">Belum ada konten.</span>' !!}
                </div>
            </div>
            <div class="bg-primary-100 rounded-2xl p-8 hover:shadow-lg transition reveal">
                <div class="text-primary-600 font-bold text-lg mb-3">Misi</div>
                <div class="text-slate-600 leading-relaxed whitespace-pre-line">
                    {!! $content->misi_text ? Str::inlineMarkdown(e($content->misi_text)) : '<span class="text-slate-400 italic">Belum ada konten.</span>' !!}
                </div>
            </div>
        </div>
    </section>

    <section id="struktur" class="py-16 scroll-mt-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-center mb-8 reveal">Struktur Organisasi</h2>
            <div class="prose max-w-none text-slate-600 leading-relaxed mb-8 reveal whitespace-pre-line">
                {!! $content->struktur_text ? Str::inlineMarkdown(e($content->struktur_text)) : '<p class="text-slate-400 italic">Belum ada konten.</p>' !!}
            </div>
            @if($content->struktur_image)
                <img src="{{ asset('storage/' . $content->struktur_image) }}"
                    onclick="openLightbox(['{{ asset('storage/' . $content->struktur_image) }}'], 0)"
                    class="w-full rounded-xl border cursor-pointer hover:opacity-90 transition reveal" loading="lazy" decoding="async">
            @endif
        </div>
    </section>

    {{-- ===== Kuasa Pemilik Modal — DUAN, kartu horizontal: foto kiri, teks + tombol kanan ===== --}}
    @if($pemilikModal->count())
        <section id="pemilik-modal" class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 scroll-mt-20">
            <h2 class="text-2xl sm:text-3xl font-bold text-center mb-12 reveal">Kuasa Pemilik Modal</h2>
            <div class="space-y-5">
                @foreach($pemilikModal as $d)
                    <div
                        class="flex flex-col sm:flex-row bg-white border rounded-2xl overflow-hidden hover:shadow-lg transition-all reveal">
                        <div class="w-full h-56 sm:h-auto sm:w-56 shrink-0 overflow-hidden bg-slate-100">
                            <img src="{{ $d->photo ? asset('storage/' . $d->photo) : 'https://placehold.co/400x500/e2e8f0/64748b?text=Foto' }}"
                                class="w-full h-full object-cover" loading="lazy" decoding="async">
                        </div>
                        <div class="p-6 flex flex-col justify-center">
                            <div class="font-bold text-lg">{{ $d->name }}</div>
                            <div class="text-primary-600 text-sm mb-3">{{ $d->position }}</div>
                            @if($d->description)
                                <p class="text-slate-600 text-sm leading-relaxed line-clamp-3 mb-4">{{ $d->description }}</p>
                            @endif
                            <button onclick="openDirectorModal({{ $d->id }})"
                                class="self-start inline-flex items-center gap-1.5 text-sm font-medium border rounded-full px-4 py-2 hover:bg-primary-50 hover:border-primary-300 transition">
                                Selengkapnya →
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ===== Jajaran Direksi — kartu bordered, flex-wrap centered biar baris terakhir rapi walau gak penuh 3 ===== --}}
    <section id="direksi" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 scroll-mt-20">
        <h2 class="text-2xl sm:text-3xl font-bold text-center mb-12 reveal">Jajaran Direksi</h2>
        <div class="flex flex-wrap justify-center gap-6">
            @forelse($direksi as $d)
                <button onclick="openDirectorModal({{ $d->id }})"
                    class="group text-left bg-white rounded-2xl border-2 border-slate-200 overflow-hidden hover:border-primary-400 hover:shadow-xl transition-all w-full sm:w-[280px] reveal">
                    <div class="aspect-[4/5] overflow-hidden">
                        <img src="{{ $d->photo ? asset('storage/' . $d->photo) : 'https://placehold.co/400x500/e2e8f0/64748b?text=Foto' }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" decoding="async">
                    </div>
                    <div class="p-4">
                        <div class="font-bold">{{ $d->name }}</div>
                        <div class="text-primary-600 text-sm">{{ $d->position }}</div>
                    </div>
                </button>
            @empty
                <p class="text-slate-400 text-center">Belum ada data direksi.</p>
            @endforelse
        </div>
    </section>

    {{-- Modal detail direksi (foto tidak bisa klik-full-view sesuai instruksi) --}}
    <div id="directorModal" class="fixed inset-0 bg-black/70 z-[9998] hidden items-center justify-center p-3 sm:p-4"
        onclick="closeDirectorModal()">
        <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[85vh] sm:max-h-[540px] flex flex-col sm:grid sm:grid-cols-2 overflow-hidden shadow-2xl relative"
            onclick="event.stopPropagation()">
            <!-- Close button visible on top right -->
            <button onclick="closeDirectorModal()"
                class="absolute top-3 right-3 z-10 w-8 h-8 rounded-full bg-slate-900/60 hover:bg-slate-900 text-white flex items-center justify-center text-xl leading-none transition">×</button>

            <div class="w-full h-64 sm:h-full shrink-0 bg-slate-100 overflow-hidden relative">
                <img id="directorModalPhoto" class="w-full h-full object-cover object-top">
            </div>

            <div class="p-5 sm:p-6 overflow-y-auto flex-1 max-h-[50vh] sm:max-h-[540px]">
                <h3 id="directorModalName" class="text-lg sm:text-xl font-bold text-slate-900 pr-6"></h3>
                <p id="directorModalPosition" class="text-primary-600 font-semibold text-xs sm:text-sm mb-3 sm:mb-4"></p>
                <div id="directorModalDesc" class="text-slate-600 text-xs sm:text-sm leading-relaxed whitespace-pre-line">
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @php
            $directorsForJs = collect($direksi)->merge($pemilikModal)->map(fn($d) => [
                'id' => $d->id,
                'name' => $d->name,
                'position' => $d->position,
                'description' => $d->description,
                'photo' => $d->photo ? asset('storage/' . $d->photo) : 'https://placehold.co/400x500/e2e8f0/64748b?text=Foto',
            ]);
        @endphp
        <script>
            const directorsData = @json($directorsForJs);

            function openDirectorModal(id) {
                const d = directorsData.find(x => x.id === id);
                if (!d) return;
                document.getElementById('directorModalPhoto').src = d.photo;
                document.getElementById('directorModalName').textContent = d.name;
                document.getElementById('directorModalPosition').textContent = d.position;
                document.getElementById('directorModalDesc').textContent = d.description || '';
                const modal = document.getElementById('directorModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
            function closeDirectorModal() {
                const modal = document.getElementById('directorModal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        </script>
    @endpush
@endsection