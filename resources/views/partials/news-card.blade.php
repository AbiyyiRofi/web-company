@php
    $imgs = $item->images->count()
        ? $item->images->pluck('image_path')->map(fn($p) => asset('storage/'.$p))
        : ($item->cover_image ? [asset('storage/'.$item->cover_image)] : ['https://placehold.co/600x350/2563eb/white?text=PDAM+TDA']);
@endphp
<a href="{{ route('news.show', $item->slug) }}" class="group block bg-white rounded-xl border shadow-sm overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all reveal">
    <div class="h-44 overflow-hidden auto-rotate-images" data-images='@json($imgs)'>
        <img class="rotate-img fade-img w-full h-full object-cover" src="{{ $imgs[0] }}">
    </div>
    <div class="p-5">
        <span class="text-xs font-semibold text-red-600 uppercase">Perumdam TDA News</span>
        <h3 class="font-semibold mt-1 line-clamp-2 group-hover:text-primary-700 transition">{{ $item->title }}</h3>
        <p class="text-sm text-slate-400 mt-2">{{ $item->published_at?->translatedFormat('d F Y') }}</p>
    </div>
</a>
