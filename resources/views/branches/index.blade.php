@extends('layouts.app')
@section('title', 'Hubungi Kami')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #branchMap { height: 600px; width: 100%; }
    /* Leaflet default z-index (panes ~400-650, controls ~1000) ngalahin navbar sticky
       kita (z-50). Turunin z-index internal leaflet biar navbar selalu di atas peta. */
    .leaflet-pane, .leaflet-top, .leaflet-bottom, .leaflet-control { z-index: 10 !important; }
</style>
@endpush

@section('content')
<section class="relative h-64 sm:h-72 bg-slate-900 overflow-hidden">
    <img src="{{ $content->header_image ? asset('storage/'.$content->header_image) : 'https://placehold.co/1600x600/1e3a8a/white?text=Hubungi+Kami' }}" class="w-full h-full object-cover brightness-[0.45] blur-[1px]">
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 w-full">
            @include('partials.breadcrumb', ['currentPage' => 'Hubungi Kami'])
            <h1 class="text-3xl sm:text-4xl font-bold text-white">Hubungi Kami</h1>
            @if($content->header_caption)
                <p class="text-primary-100 mt-2 max-w-2xl">{{ $content->header_caption }}</p>
            @endif
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <h2 class="text-2xl sm:text-3xl font-bold text-center mb-10">Peta dan Kontak Cabang &amp; Unit<br>PERUMDAM Tirta Darma Ayu</h2>

    <div class="grid lg:grid-cols-5 gap-6">
        <div class="lg:col-span-2 max-h-[600px] overflow-y-auto space-y-3 pr-1">
            @foreach ($branches as $b)
                <div class="bg-white border rounded-xl p-4 hover:border-primary-400 hover:shadow-md transition-all cursor-pointer" onclick="focusBranch({{ $b->latitude }}, {{ $b->longitude }}, {{ $b->id }})">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex items-start gap-2">
                            <span class="text-lg mt-0.5">📍</span>
                            <div>
                                <div class="font-semibold text-sm">{{ $b->name }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">{{ $b->address }}</div>
                            </div>
                        </div>
                        @if($b->is_head_office)
                            <span class="shrink-0 text-xs bg-primary-100 text-primary-700 px-2 py-0.5 rounded-full font-medium">Pusat</span>
                        @endif
                    </div>
                    @if($b->whatsapp_link)
                        <a href="{{ $b->whatsapp_link }}" target="_blank" onclick="event.stopPropagation()"
                           class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-emerald-500 text-white hover:bg-emerald-600 hover:scale-105 transition-all">
                            💬 Chat Sekarang
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="lg:col-span-3 rounded-2xl overflow-hidden shadow-sm border">
            <div id="branchMap"></div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const map = L.map('branchMap').setView([-6.38, 108.20], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors', maxZoom: 18,
    }).addTo(map);

    const markers = {};
    const pinIcon = (big) => L.divIcon({ html: `<span style="font-size:${big ? 32 : 26}px">📍</span>`, className: '', iconSize: [30,30], iconAnchor: [15,30] });

    fetch("{{ route('branches.json') }}")
        .then(res => res.json())
        .then(branches => {
            branches.forEach(b => {
                const marker = L.marker([b.latitude, b.longitude], { icon: pinIcon(b.is_head_office) }).addTo(map);
                marker.bindPopup(`
                    <div style="min-width:180px">
                        <strong>${b.name}</strong><br>
                        <span style="font-size:12px;color:#555">${b.address}</span><br>
                        ${b.whatsapp_link ? `<a href="${b.whatsapp_link}" target="_blank" style="display:inline-block;margin-top:6px;background:#10b981;color:white;padding:4px 10px;border-radius:999px;font-size:11px;text-decoration:none;">💬 Chat Sekarang</a>` : ''}
                    </div>
                `);
                markers[b.id] = marker;
            });
        });

    function focusBranch(lat, lng, id) {
        map.flyTo([lat, lng], 15);
        if (markers[id]) markers[id].openPopup();
    }
</script>
@endpush
