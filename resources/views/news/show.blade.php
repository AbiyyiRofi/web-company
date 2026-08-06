@extends('layouts.app')
@section('title', $item->title)

@section('content')
<section class="relative bg-gradient-to-r from-primary-900 via-primary-800 to-primary-900 text-white overflow-hidden pt-28 pb-12 sm:pt-36 sm:pb-16">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:text-left" data-reveal-group>
        @include('partials.breadcrumb', ['currentPage' => 'Berita'])
        <h1 class="text-2xl sm:text-4xl font-extrabold text-white mt-3 leading-tight drop-shadow-sm reveal">{{ $item->title }}</h1>
        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4 text-xs sm:text-sm text-primary-100 mt-4 reveal">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 backdrop-blur-sm border border-white/10 font-semibold text-white">
                 Perumdam TDA News
            </span>
            <span> {{ $item->published_at?->translatedFormat('d F Y, H:i') }}</span>
            <span> {{ $item->user->name ?? 'Admin PDAM' }}</span>
        </div>
    </div>
</section>

<article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10" data-reveal-group>

    @if($item->images->count())
        @php $imgUrls = $item->images->pluck('image_path')->map(fn($p)=>asset('storage/'.$p)); @endphp
        <div class="relative mb-8 -mx-4 sm:mx-0 reveal">
            <div id="newsCarousel" class="flex gap-2 overflow-x-auto snap-x snap-mandatory rounded-xl px-4 sm:px-0" style="scroll-behavior:smooth">
                @foreach($item->images as $i => $img)
                    <img src="{{ asset('storage/'.$img->image_path) }}"
                         class="snap-center shrink-0 w-[92%] sm:w-full max-h-[520px] object-contain bg-slate-100 rounded-xl cursor-pointer hover:opacity-95 transition"
                         onclick="openLightbox(@json($imgUrls), {{ $i }})">
                @endforeach
            </div>
            @if($item->images->count() > 1)
                <div class="flex justify-center gap-1.5 mt-3">
                    @foreach($item->images as $i => $img)
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    @endforeach
                </div>
                <p class="text-center text-xs text-slate-400 mt-1">Geser untuk lihat foto lainnya · klik foto untuk lihat penuh</p>
            @endif
        </div>
    @endif

    <div class="prose max-w-none text-slate-700 leading-relaxed reveal">
        {!! nl2br(e($item->content)) !!}
    </div>

    <a href="{{ route('news.index') }}" class="inline-block mt-10 text-primary-600 hover:underline reveal">← Kembali ke Perumdam TDA News</a>
</article>

@if($related->count())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <h2 class="text-xl font-bold mb-6 reveal">Berita Terkait</h2>
    <div class="grid md:grid-cols-3 gap-6" data-reveal-group>
        @foreach($related as $r)
            @php $rImg = $r->cover_image ? asset('storage/'.$r->cover_image) : 'https://placehold.co/600x350/2563eb/white?text=PDAM+TDA'; @endphp
            <a href="{{ route('news.show', $r->slug) }}" class="group block bg-white rounded-xl border shadow-sm overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all reveal">
                <img src="{{ $rImg }}" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold text-sm line-clamp-2 group-hover:text-primary-700 transition">{{ $r->title }}</h3>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif

@push('scripts')
<script>
    // auto-scroll carousel pelan (bisa dihentikan dengan sentuh/scroll manual)
    (function () {
        const carousel = document.getElementById('newsCarousel');
        if (!carousel || carousel.children.length <= 1) return;
        let autoTimer = setInterval(() => {
            const maxScroll = carousel.scrollWidth - carousel.clientWidth;
            if (carousel.scrollLeft >= maxScroll - 5) {
                carousel.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                carousel.scrollBy({ left: carousel.clientWidth * 0.92, behavior: 'smooth' });
            }
        }, 4000);
        ['touchstart', 'wheel', 'mousedown'].forEach(evt =>
            carousel.addEventListener(evt, () => clearInterval(autoTimer), { once: true })
        );
    })();
</script>
@endpush
@endsection
