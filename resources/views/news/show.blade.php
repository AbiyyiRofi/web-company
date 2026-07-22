@extends('layouts.app')
@section('title', $item->title)

@section('content')
<article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <span class="text-xs font-semibold text-red-600 uppercase">Perumdam TDA News</span>
    <h1 class="text-2xl sm:text-3xl font-bold mt-2 mb-3">{{ $item->title }}</h1>
    <p class="text-sm text-slate-500 mb-6">{{ $item->published_at?->translatedFormat('d F Y, H:i') }} · {{ $item->user->name ?? 'Admin' }}</p>

    @if($item->images->count())
        @php $imgUrls = $item->images->pluck('image_path')->map(fn($p)=>asset('storage/'.$p)); @endphp
        <div class="relative mb-8 -mx-4 sm:mx-0">
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

    <div class="prose max-w-none text-slate-700 leading-relaxed">
        {!! nl2br(e($item->content)) !!}
    </div>

    <a href="{{ route('news.index') }}" class="inline-block mt-10 text-primary-600 hover:underline">← Kembali ke Perumdam TDA News</a>
</article>

@if($related->count())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <h2 class="text-xl font-bold mb-6">Berita Terkait</h2>
    <div class="grid md:grid-cols-3 gap-6">
        @foreach($related as $r)
            @php $rImg = $r->cover_image ? asset('storage/'.$r->cover_image) : 'https://placehold.co/600x350/2563eb/white?text=PDAM+TDA'; @endphp
            <a href="{{ route('news.show', $r->slug) }}" class="group block bg-white rounded-xl border shadow-sm overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all">
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
