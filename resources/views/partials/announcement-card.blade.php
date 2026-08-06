<button type="button" onclick="openAnnouncementModal({{ $ann->id }})"
        class="group block text-left bg-white rounded-xl border shadow-sm overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all w-full reveal">
    <div class="h-44 overflow-hidden bg-slate-100">
        @if($ann->image)
            <img class="w-full h-full object-cover" src="{{ asset('storage/'.$ann->image) }}">
        @else
            <div class="w-full h-full flex items-center justify-center text-4xl">📢</div>
        @endif
    </div>
    <div class="p-5">
        <span class="text-xs font-semibold text-primary-600 uppercase">Pengumuman</span>
        <h3 class="font-semibold mt-1 line-clamp-2 group-hover:text-primary-700 transition">{{ $ann->title }}</h3>
        <p class="text-sm text-slate-400 mt-2">{{ $ann->created_at->translatedFormat('d F Y') }}</p>
    </div>
</button>