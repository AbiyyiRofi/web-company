@extends('layouts.app')
@section('title', 'Pengadaan')

@section('content')
<section class="relative h-64 sm:h-72 bg-slate-900 overflow-hidden">
    <img src="{{ $content->header_image ? asset('storage/'.$content->header_image) : 'https://placehold.co/1600x600/1e3a8a/white?text=Pengadaan' }}" class="w-full h-full object-cover brightness-[0.45] blur-[1px]">
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 w-full" data-reveal-group>
            @include('partials.breadcrumb', ['currentPage' => 'Informasi Pengadaan'])
            <h1 class="text-3xl sm:text-4xl font-bold text-white reveal">Informasi Pengadaan</h1>
            @if($content->header_caption)
                <p class="text-primary-100 mt-2 max-w-2xl reveal">{{ $content->header_caption }}</p>
            @endif
        </div>
    </div>
</section>

{{-- Info + tombol ke portal Pengadaan Online eksternal --}}
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 text-center" data-reveal-group>
    <div class="bg-gradient-to-br from-primary-700 to-primary-900 rounded-3xl p-10 sm:p-14 text-white reveal">
        <h2 class="text-xl sm:text-2xl font-bold mb-6">Informasi Mengenai Pengadaan Online</h2>
        <a href="https://pengadaan.pdamindramayu.co.id" target="_blank" rel="noopener"
           class="inline-flex items-center gap-2 px-8 py-4 bg-white text-primary-700 font-semibold rounded-full hover:scale-105 hover:shadow-xl transition-all">
            Klik Disini! →
        </a>
    </div>
</section>

<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12" data-reveal-group>
    @forelse($procurements as $p)
        <div class="reveal">
            <h2 class="text-2xl font-bold mb-3">{{ $p->title }}</h2>
            @if($p->description)
                <div class="prose max-w-none text-slate-600 leading-relaxed mb-5">{!! nl2br(e($p->description)) !!}</div>
            @endif
            <div class="space-y-3" data-reveal-group>
                @forelse($p->documents as $doc)
                    <a href="{{ route('procurement.download', $doc) }}" class="flex items-center gap-4 bg-white border rounded-xl p-4 hover:shadow-lg hover:border-primary-300 transition-all reveal">
                        <span class="text-3xl">📄</span>
                        <div>
                            <div class="font-medium">{{ $doc->title }}</div>
                            <div class="text-primary-600 text-xs font-semibold">Unduh · {{ strtoupper($doc->file_type) }}</div>
                        </div>
                    </a>
                @empty
                    <p class="text-slate-400 text-sm reveal">Tidak ada dokumen terlampir.</p>
                @endforelse
            </div>
        </div>
    @empty
        <p class="text-slate-400 text-center reveal">Belum ada informasi pengadaan.</p>
    @endforelse
</section>
@endsection
