@extends('layouts.app')
@section('title', 'Pengumuman')

@section('content')
    <section class="relative h-64 sm:h-72 bg-slate-900 overflow-hidden">
        <img src="{{ $header->header_image ? asset('storage/' . $header->header_image) : 'https://placehold.co/1600x600/1d4ed8/white?text=Pengumuman' }}"
            class="w-full h-full object-cover brightness-[0.45] blur-[1px]">
        <div class="absolute inset-0 flex items-end">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 w-full" data-reveal-group>
                @include('partials.breadcrumb', ['currentPage' => 'Pengumuman'])
                <h1 class="text-3xl sm:text-4xl font-bold text-white reveal">Pengumuman</h1>
                @if($header->header_caption)
                    <p class="text-primary-100 mt-2 max-w-2xl reveal">{{ $header->header_caption }}</p>
                @endif
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid md:grid-cols-3 gap-6" data-reveal-group>
            @forelse ($announcements as $ann)
                @include('partials.announcement-card', ['ann' => $ann])
            @empty
                <p class="text-slate-500 col-span-3 reveal">Belum ada pengumuman.</p>
            @endforelse
        </div>
    </section>

    <div id="announcementModal" class="fixed inset-0 bg-black/70 z-[9998] hidden items-center justify-center p-4"
        onclick="closeAnnouncementModal()">
        <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[85vh] overflow-y-auto p-6 sm:p-8"
            onclick="event.stopPropagation()">
            <button onclick="closeAnnouncementModal()"
                class="float-right text-slate-400 hover:text-slate-600 text-2xl leading-none">×</button>
            <h3 id="annModalTitle" class="font-bold text-xl mb-1"></h3>
            <p id="annModalDate" class="text-xs text-slate-400 mb-4"></p>
            <p id="annModalDesc" class="text-slate-600 whitespace-pre-line text-justify mb-4"></p>
            <div id="annModalDocWrap" class="hidden">
                <a id="annModalDocLink" target="_blank"
                    class="flex items-center gap-3 bg-slate-50 hover:bg-primary-50 rounded-xl p-4 mb-4 transition">
                    <span class="text-2xl">📄</span>
                    <div>
                        <div class="font-medium text-sm">Dokumen Lampiran</div>
                        <div class="text-primary-600 text-xs font-semibold">Unduh</div>
                    </div>
                </a>
            </div>
            <img id="annModalImage" class="w-full rounded-xl cursor-pointer hover:opacity-95 transition hidden">
        </div>
    </div>

    @php
        $announcementsForJs = $announcements->map(function ($a) {
            return [
                'id' => $a->id,
                'title' => $a->title,
                'date' => $a->created_at->translatedFormat('d F Y'),
                'description' => $a->description,
                'image' => $a->image ? asset('storage/' . $a->image) : null,
                'document' => $a->document_path ? asset('storage/' . $a->document_path) : null,
            ];
        });
    @endphp

    @push('scripts')
        <script>
            const announcementsData = @json($announcementsForJs);

            function openAnnouncementModal(id) {
                const a = announcementsData.find(x => x.id === id);
                if (!a) return;
                document.getElementById('annModalTitle').textContent = a.title;
                document.getElementById('annModalDate').textContent = a.date;
                document.getElementById('annModalDesc').textContent = a.description || '';

                const docWrap = document.getElementById('annModalDocWrap');
                const docLink = document.getElementById('annModalDocLink');
                if (a.document) { docWrap.classList.remove('hidden'); docLink.href = a.document; } else { docWrap.classList.add('hidden'); }

                const img = document.getElementById('annModalImage');
                if (a.image) {
                    img.src = a.image;
                    img.classList.remove('hidden');
                    img.onclick = () => openLightbox([a.image], 0);
                } else {
                    img.classList.add('hidden');
                }

                const modal = document.getElementById('announcementModal');
                modal.classList.remove('hidden'); modal.classList.add('flex');
            }
            function closeAnnouncementModal() {
                const modal = document.getElementById('announcementModal');
                modal.classList.add('hidden'); modal.classList.remove('flex');
            }
        </script>
    @endpush
@endsection