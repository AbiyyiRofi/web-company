<button type="button" onclick="openAnnouncementModal({{ $ann->id }})"
        class="group block text-left bg-white rounded-xl border shadow-sm overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all w-full reveal">
    <div class="h-44 overflow-hidden bg-slate-100">
        @if($ann->image)
            <img class="w-full h-full object-cover" src="{{ asset('storage/'.$ann->image) }}" loading="lazy" decoding="async">
        @else
            <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c.41 0 .789-.244.945-.623l.775-1.938a1.5 1.5 0 012.796.885v10.354a1.5 1.5 0 01-2.796.885l-.775-1.938a1.002 1.002 0 00-.945-.623H7a3.988 3.988 0 01-1.564-.317z"/></svg>
            </div>
        @endif
    </div>
    <div class="p-5">
        <span class="text-xs font-semibold text-primary-600 uppercase">Pengumuman</span>
        <h3 class="font-semibold mt-1 line-clamp-2 group-hover:text-primary-700 transition">{{ $ann->title }}</h3>
        <p class="text-sm text-slate-400 mt-2">{{ $ann->created_at->translatedFormat('d F Y') }}</p>
    </div>
</button>