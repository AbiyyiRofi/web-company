@php $sliderId = $sliderId ?? 'annSlider'; @endphp
<div id="{{ $sliderId }}" class="relative" data-count="{{ $announcements->count() }}">
    <div class="overflow-hidden rounded-2xl">
        <div id="{{ $sliderId }}Track" class="flex transition-transform duration-500 ease-out">
            @forelse ($announcements as $index => $ann)
                @php $descLong = $ann->description && \Illuminate\Support\Str::length($ann->description) > 260; @endphp
                <div class="w-full shrink-0 px-1">
                    <div class="bg-white rounded-2xl border shadow-sm p-6 sm:p-8">
                        <h3 class="font-bold text-lg sm:text-xl mb-1">{{ $ann->title }}</h3>
                        <p class="text-xs text-slate-400 mb-4">{{ $ann->created_at->translatedFormat('d F Y') }}</p>

                        @if($ann->description)
                            <div class="mb-4">
                                <p id="{{ $sliderId }}Desc{{ $index }}" class="text-slate-600 whitespace-pre-line text-justify {{ $descLong ? 'line-clamp-4' : '' }}">{{ $ann->description }}</p>
                                @if($descLong)
                                    <button type="button" onclick="annToggleDesc('{{ $sliderId }}Desc{{ $index }}', this)" class="text-primary-600 text-sm font-semibold mt-1 hover:underline">Baca Selengkapnya</button>
                                @endif
                            </div>
                        @endif

                        @if($ann->document_path)
                            <a href="{{ asset('storage/'.$ann->document_path) }}" target="_blank"
                               class="flex items-center gap-3 bg-slate-50 hover:bg-primary-50 rounded-xl p-4 mb-4 transition">
                                <span class="text-2xl">📄</span>
                                <div>
                                    <div class="font-medium text-sm">{{ $ann->title }}</div>
                                    <div class="text-primary-600 text-xs font-semibold">Unduh</div>
                                </div>
                            </a>
                        @endif

                        @if($ann->image)
                            <img src="{{ asset('storage/'.$ann->image) }}"
                                 onclick="openLightbox(['{{ asset('storage/'.$ann->image) }}'], 0)"
                                 class="w-full rounded-xl cursor-pointer hover:opacity-95 transition">
                        @endif
                    </div>
                </div>
            @empty
                <div class="w-full shrink-0 px-1">
                    <p class="text-slate-500 text-center py-10">Belum ada pengumuman.</p>
                </div>
            @endforelse
        </div>
    </div>

    @if($announcements->count() > 1)
        <div class="flex items-center justify-center gap-4 mt-5">
            <button type="button" onclick="annSliderMove('{{ $sliderId }}', -1)"
                    class="w-10 h-10 rounded-full bg-white shadow-lg border flex items-center justify-center hover:bg-slate-50 transition">‹</button>
            <div class="flex gap-1.5">
                @foreach ($announcements as $i => $ann)
                    <span id="{{ $sliderId }}Dot{{ $i }}" class="w-2 h-2 rounded-full transition {{ $i === 0 ? 'bg-primary-600' : 'bg-slate-300' }}"></span>
                @endforeach
            </div>
            <button type="button" onclick="annSliderMove('{{ $sliderId }}', 1)"
                    class="w-10 h-10 rounded-full bg-white shadow-lg border flex items-center justify-center hover:bg-slate-50 transition">›</button>
        </div>
    @endif
</div>

<script>
    if (typeof window.annSliderMove !== 'function') {
        window.annSliderState = window.annSliderState || {};

        window.annSliderMove = function (id, dir) {
            var track = document.getElementById(id + 'Track');
            var wrapper = document.getElementById(id);
            if (!track || !wrapper) return;
            var count = parseInt(wrapper.dataset.count, 10);
            if (!count || count <= 1) return;

            var current = window.annSliderState[id] || 0;
            current = (current + dir + count) % count;
            window.annSliderState[id] = current;

            track.style.transform = 'translateX(-' + (current * 100) + '%)';

            for (var i = 0; i < count; i++) {
                var dot = document.getElementById(id + 'Dot' + i);
                if (dot) dot.className = 'w-2 h-2 rounded-full transition ' + (i === current ? 'bg-primary-600' : 'bg-slate-300');
            }
        };

        window.annToggleDesc = function (descId, btn) {
            var el = document.getElementById(descId);
            if (!el) return;
            var collapsed = el.classList.toggle('line-clamp-4');
            btn.textContent = collapsed ? 'Baca Selengkapnya' : 'Sembunyikan';
        };

        document.querySelectorAll('[id$="Track"]').forEach(function (track) {
            var startX = 0, isDown = false;
            var sliderId = track.id.replace(/Track$/, '');

            track.addEventListener('touchstart', function (e) {
                startX = e.touches[0].clientX; isDown = true;
            }, { passive: true });

            track.addEventListener('touchend', function (e) {
                if (!isDown) return;
                isDown = false;
                var diff = e.changedTouches[0].clientX - startX;
                if (Math.abs(diff) > 50) {
                    window.annSliderMove(sliderId, diff < 0 ? 1 : -1);
                }
            });
        });
    }
</script>