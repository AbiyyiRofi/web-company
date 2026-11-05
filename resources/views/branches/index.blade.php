@extends('layouts.app')
@section('title', 'Hubungi Kami')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #branchMap {
            height: 600px;
            width: 100%;
        }

        .leaflet-pane,
        .leaflet-top,
        .leaflet-bottom,
        .leaflet-control {
            z-index: 10 !important;
        }
    </style>
@endpush

@section('content')
    <section class="relative h-64 sm:h-72 bg-slate-900 overflow-hidden">
        <img src="{{ $content->header_image ? asset('storage/' . $content->header_image) : 'https://placehold.co/1600x600/1e3a8a/white?text=Hubungi+Kami' }}"
            class="w-full h-full object-cover brightness-[0.45] blur-[1px]">
        <div class="absolute inset-0 flex items-end">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 w-full" data-reveal-group>
                @include('partials.breadcrumb', ['currentPage' => 'Hubungi Kami'])
                <h1 class="text-3xl sm:text-4xl font-bold text-white reveal">Hubungi Kami</h1>
                @if($content->header_caption)
                    <p class="text-primary-100 mt-2 max-w-2xl reveal">{{ $content->header_caption }}</p>
                @endif
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <h2 class="text-2xl sm:text-3xl font-bold text-center mb-10 reveal">Peta dan Kontak Cabang &amp; Unit<br>PERUMDAM Tirta
            Darma Ayu</h2>

        <div class="grid lg:grid-cols-5 gap-6">
            <div class="lg:col-span-2 max-h-[600px] overflow-y-auto space-y-3 pr-1" data-reveal-group>
                @foreach ($branches as $b)
                    <div id="branch-card-{{ $b->id }}" class="branch-card bg-white border rounded-xl p-4 hover:border-primary-400 hover:shadow-md transition-all cursor-pointer reveal"
                        onclick="focusBranch({{ $b->latitude }}, {{ $b->longitude }}, {{ $b->id }})">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex items-start gap-2">
                                <span class="shrink-0 w-7 h-7 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </span>
                                <div>
                                    <div class="font-semibold text-sm">{{ $b->name }}</div>
                                    <div class="text-xs text-slate-500 mt-0.5">{{ $b->address }}</div>
                                </div>
                            </div>
                            @if($b->is_head_office)
                                <span
                                    class="shrink-0 text-xs bg-primary-100 text-primary-700 px-2 py-0.5 rounded-full font-medium">Pusat</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 mt-3" onclick="event.stopPropagation()">
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $b->latitude }},{{ $b->longitude }}" target="_blank"
                                class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-blue-500 text-white hover:bg-blue-600 hover:scale-105 transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Google Maps</span>
                            </a>
                            @if($b->whatsapp_link)
                                <a href="{{ $b->whatsapp_link }}" target="_blank"
                                    class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-emerald-500 text-white hover:bg-emerald-600 hover:scale-105 transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    <span>Chat WA</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="lg:col-span-3 rounded-2xl overflow-hidden shadow-sm border reveal">
                <div id="branchMap"></div>
            </div>
        </div>
    </section>

    {{-- ============ IPA (Instalasi Pengolahan Air) ============ --}}
    @if($ipas->count())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
            <h2 class="text-2xl sm:text-3xl font-bold text-center mb-10 reveal">IPA PERUMDAM TIRTA DARMA AYU</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" data-reveal-group>
                @foreach($ipas as $ipa)
                    <button type="button" onclick="focusBranch({{ $ipa->latitude }}, {{ $ipa->longitude }}, {{ $ipa->id }})"
                        class="text-left bg-white border rounded-2xl p-6 hover:border-primary-400 hover:shadow-lg hover:-translate-y-1 transition-all reveal">
                        <h3 class="font-bold text-base mb-3">{{ $ipa->name }}</h3>
                        <div class="text-slate-600 text-sm leading-relaxed whitespace-pre-line text-justify mb-2 line-clamp-4">
                            1. {{ $ipa->kapasitas_terpasang_text }}
                        </div>
                        @if($ipa->kapasitas_produksi)
                            <p class="text-slate-600 text-sm mb-1">2. Kapasitas Produksi: {{ $ipa->kapasitas_produksi }}</p>
                        @endif
                        @if($ipa->idle_capacity)
                            <p class="text-slate-600 text-sm mb-3">3. Idle Capacity: {{ $ipa->idle_capacity }}</p>
                        @endif
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-3">
                            <svg class="w-3.5 h-3.5 text-primary-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ $ipa->address }}</span>
                        </p>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $ipa->latitude }},{{ $ipa->longitude }}" target="_blank" onclick="event.stopPropagation()"
                            class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-blue-500 text-white hover:bg-blue-600 transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Google Maps</span>
                        </a>
                    </button>
                @endforeach
            </div>
        </section>
    @endif
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Bounding box area Kabupaten Indramayu (South-West to North-East)
        const indramayuBounds = L.latLngBounds(
            L.latLng(-6.75, 107.80),
            L.latLng(-6.05, 108.65)
        );

        const map = L.map('branchMap', {
            maxBounds: indramayuBounds,
            maxBoundsViscosity: 1.0, // Membatasi pergeseran peta agar tidak keluar dari wilayah Indramayu
            minZoom: 10,
            maxZoom: 18
        }).setView([-6.38, 108.20], 11);

        // Tile Layers
        const standardTile = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 18,
            minZoom: 10
        });

        // Satellite Imagery (Esri World Imagery)
        const satelliteTile = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
            maxZoom: 18,
            minZoom: 10
        });

        // Street labels overlay on Satellite
        const labelsTile = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap &copy; CARTO',
            maxZoom: 18,
            minZoom: 10,
            subdomains: 'abcd'
        });

        const satelliteGroup = L.layerGroup([satelliteTile, labelsTile]);

        // Default set to Satellite view (Satelit + Nama Jalan)
        satelliteGroup.addTo(map);

        // Control layer switcher (Kanan Atas)
        const baseMaps = {
            "Satelit (Foto Udara)": satelliteGroup,
            "Peta Vektor (Standar)": standardTile
        };
        L.control.layers(baseMaps, null, { position: 'topright' }).addTo(map);

        const markers = {};
        const createCustomPin = (bgColor, iconSvg, big = false) => {
            const size = big ? 42 : 36;
            const innerSize = big ? 20 : 16;
            const svgContent = `
                <div class="custom-map-pin" style="
                    position: relative;
                    width: ${size}px;
                    height: ${Math.round(size * 1.25)}px;
                    filter: drop-shadow(0px 3px 4px rgba(0,0,0,0.3));
                    cursor: pointer;
                    transition: transform 0.2s ease;
                ">
                    <svg viewBox="0 0 36 45" width="${size}" height="${Math.round(size * 1.25)}" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 0C8.05887 0 0 8.05887 0 18C0 29.5 15.6 43.2 17.25 44.625C17.685 45.0038 18.315 45.0038 18.75 44.625C20.4 43.2 36 29.5 36 18C36 8.05887 27.9411 0 18 0Z" fill="${bgColor}" stroke="#ffffff" stroke-width="2"/>
                        <circle cx="18" cy="18" r="11" fill="#ffffff"/>
                    </svg>
                    <div style="
                        position: absolute;
                        top: ${Math.round(size * 0.18)}px;
                        left: 50%;
                        transform: translateX(-50%);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: ${bgColor};
                    ">
                        ${iconSvg}
                    </div>
                </div>
            `;
            return L.divIcon({
                html: svgContent,
                className: 'custom-leaflet-marker-pin',
                iconSize: [size, Math.round(size * 1.25)],
                iconAnchor: [size / 2, Math.round(size * 1.25)],
                popupAnchor: [0, -Math.round(size * 1.2)]
            });
        };

        // Icon SVG templates
        const buildingIconSvg = `<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3h2v2h-2V6zm0 4h2v2h-2v-2zm0 4h2v2h-2v-2zM7 6h2v2H7V6zm0 4h2v2H7v-2zm0 4h2v2H7v-2zm10 4h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V6h2v2z"/></svg>`;
        const ipaIconSvg = `<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 3L2 12h3v8h14v-8h3L12 3zm1 14h-2v-4h2v4zm0-6h-2V9h2v2z"/></svg>`;
        const waterIconSvg = `<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>`;

        const pinIcon = (isHeadOffice, isIpa) => {
            if (isHeadOffice) {
                return createCustomPin('#1d4ed8', buildingIconSvg, true); // Deep blue for Head Office
            } else if (isIpa) {
                return createCustomPin('#15803d', waterIconSvg, false); // Dark green for IPA
            } else {
                return createCustomPin('#0284c7', buildingIconSvg, false); // Sky blue for Cabang/Unit
            }
        };

        fetch("{{ route('branches.json') }}")
            .then(res => res.json())
            .then(branches => {
                branches.forEach(b => {
                    const isIpa = b.type === 'ipa';
                    const marker = L.marker([b.latitude, b.longitude], { icon: pinIcon(b.is_head_office, isIpa) }).addTo(map);

                    const gmapsUrl = `https://www.google.com/maps/search/?api=1&query=${b.latitude},${b.longitude}`;
                    let popupHtml = `<div style="min-width:200px"><strong>${b.name}</strong><br><span style="font-size:12px;color:#555">${b.address || ''}</span><br>`;
                    if (isIpa) {
                        popupHtml += `<div style="font-size:11px;color:#555;margin-top:6px;white-space:pre-line">${b.kapasitas_terpasang_text || ''}</div>`;
                        if (b.kapasitas_produksi) popupHtml += `<div style="font-size:11px;color:#555">Kapasitas Produksi: ${b.kapasitas_produksi}</div>`;
                        if (b.idle_capacity) popupHtml += `<div style="font-size:11px;color:#555">Idle Capacity: ${b.idle_capacity}</div>`;
                    }
                    popupHtml += `<div style="display:flex;gap:6px;margin-top:8px;flex-wrap:wrap;">`;
                    popupHtml += `<a href="${gmapsUrl}" target="_blank" style="display:inline-flex;align-items:center;gap:4px;background:#3b82f6;color:white;padding:4px 10px;border-radius:999px;font-size:11px;text-decoration:none;font-weight:600;"><svg style="width:12px;height:12px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Google Maps</a>`;
                    if (!isIpa && b.whatsapp_link) {
                        popupHtml += `<a href="${b.whatsapp_link}" target="_blank" style="display:inline-flex;align-items:center;gap:4px;background:#10b981;color:white;padding:4px 10px;border-radius:999px;font-size:11px;text-decoration:none;font-weight:600;"><svg style="width:12px;height:12px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg> Chat WA</a>`;
                    }
                    popupHtml += `</div></div>`;

                    marker.bindPopup(popupHtml);
                    markers[b.id] = marker;
                });

                // Otomatis fokus ke cabang jika terdapat query parameter ?branch=ID pada URL
                const urlParams = new URLSearchParams(window.location.search);
                const targetBranchId = urlParams.get('branch');
                if (targetBranchId && markers[targetBranchId]) {
                    const targetBranch = branches.find(b => b.id == targetBranchId);
                    if (targetBranch) {
                        setTimeout(() => {
                            focusBranch(targetBranch.latitude, targetBranch.longitude, targetBranch.id);
                        }, 400);
                    }
                }
            });

        function focusBranch(lat, lng, id) {
            document.querySelectorAll('.branch-card').forEach(el => el.classList.remove('border-primary-500', 'ring-2', 'ring-primary-300', 'bg-primary-50/50'));
            const card = document.getElementById('branch-card-' + id);
            if (card) {
                card.classList.add('border-primary-500', 'ring-2', 'ring-primary-300', 'bg-primary-50/50');
            }

            document.getElementById('branchMap').scrollIntoView({ behavior: 'smooth', block: 'center' });
            map.flyTo([lat, lng], 16);
            setTimeout(() => { if (markers[id]) markers[id].openPopup(); }, 500);
        }
    </script>
@endpush