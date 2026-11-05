@extends('layouts.admin')
@section('title', 'Edit Lokasi')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #pickMap { height: 360px; width: 100%; border-radius: 0.75rem; }
</style>
@endpush

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.branches.update', $branch) }}" method="POST" class="admin-card p-5 sm:p-7 space-y-6">
        @csrf @method('PUT')

        {{-- Jenis Lokasi --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Lokasi</label>
            <div class="grid grid-cols-2 gap-3 max-w-md">
                <label class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition [&:has(:checked)]:border-primary-500 [&:has(:checked)]:bg-primary-50/50">
                    <input type="radio" name="type" value="cabang" onchange="toggleTypeFields()" {{ $branch->type === 'cabang' ? 'checked' : '' }} class="text-primary-600 focus:ring-primary-500">
                    <span class="text-xs sm:text-sm font-medium text-slate-700">Cabang / Unit</span>
                </label>
                <label class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition [&:has(:checked)]:border-primary-500 [&:has(:checked)]:bg-primary-50/50">
                    <input type="radio" name="type" value="ipa" onchange="toggleTypeFields()" {{ $branch->type === 'ipa' ? 'checked' : '' }} class="text-primary-600 focus:ring-primary-500">
                    <span class="text-xs sm:text-sm font-medium text-slate-700">IPA (Pengolahan Air)</span>
                </label>
            </div>
        </div>

        {{-- Nama --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5" id="nameLabel">Nama</label>
            <input type="text" name="name" value="{{ old('name', $branch->name) }}" class="admin-input" required>
        </div>

        {{-- FIELD KHUSUS CABANG --}}
        <div id="cabangFields" class="space-y-5">
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Jam Operasional</label>
                    <input type="text" name="operational_hours" value="{{ old('operational_hours', $branch->operational_hours) }}" class="admin-input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">No. WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $branch->whatsapp) }}" class="admin-input">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">No. Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $branch->phone) }}" class="admin-input">
            </div>
            <label class="inline-flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" name="is_head_office" value="1" {{ $branch->is_head_office ? 'checked' : '' }} class="rounded text-primary-600 focus:ring-primary-500">
                <span class="text-sm font-medium text-slate-700">Tandai sebagai Kantor Pusat</span>
            </label>
        </div>

        {{-- FIELD KHUSUS IPA --}}
        <div id="ipaFields" class="space-y-5 hidden">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">1. Kapasitas Terpasang</label>
                <textarea name="kapasitas_terpasang_text" rows="4" class="admin-input">{{ old('kapasitas_terpasang_text', $branch->kapasitas_terpasang_text) }}</textarea>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">2. Kapasitas Produksi</label>
                    <input type="text" name="kapasitas_produksi" value="{{ old('kapasitas_produksi', $branch->kapasitas_produksi) }}" class="admin-input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">3. Idle Capacity</label>
                    <input type="text" name="idle_capacity" value="{{ old('idle_capacity', $branch->idle_capacity) }}" class="admin-input">
                </div>
            </div>
        </div>

        {{-- Alamat --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Lengkap</label>
            <input type="text" name="address" value="{{ old('address', $branch->address) }}" class="admin-input" required>
        </div>

        {{-- Map Picker --}}
        <div>
            <div class="flex items-center justify-between mb-2">
                <label class="block text-sm font-semibold text-slate-700">Titik Lokasi Peta</label>
                <button type="button" id="btnGeolocate" class="inline-flex items-center gap-1.5 text-xs text-primary-600 font-semibold hover:underline">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                    Gunakan Lokasi Saat Ini
                </button>
            </div>

            <div class="mb-3 p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
                <div class="flex gap-2">
                    <input type="text" id="mapSearchInput" placeholder="Cari jalan/alamat atau tempel link Google Maps / koordinat..." class="admin-input text-xs">
                    <button type="button" id="btnMapSearch" class="btn-primary text-xs shrink-0 py-2">
                        Cari / Tempel
                    </button>
                </div>
                <p id="searchStatus" class="text-[11px] text-slate-400">Ketik nama lokasi atau paste koordinat (misal: <em>-6.345, 108.323</em>).</p>
            </div>

            <div class="border border-slate-200 rounded-xl overflow-hidden shadow-inner relative z-0">
                <div id="pickMap"></div>
            </div>

            <div class="grid grid-cols-2 gap-3 mt-3">
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Latitude</label>
                    <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude', $branch->latitude) }}" placeholder="-6.380000" class="admin-input text-xs font-mono" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Longitude</label>
                    <input type="number" step="any" name="longitude" id="longitude" value="{{ old('longitude', $branch->longitude) }}" placeholder="108.200000" class="admin-input text-xs font-mono" required>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-3 border-t border-slate-100">
            <button class="btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.branches.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    function toggleTypeFields() {
        const type = document.querySelector('input[name="type"]:checked')?.value || 'cabang';
        document.getElementById('cabangFields').classList.toggle('hidden', type !== 'cabang');
        document.getElementById('ipaFields').classList.toggle('hidden', type !== 'ipa');
        document.getElementById('nameLabel').textContent = type === 'ipa' ? 'Nama IPA' : 'Nama Cabang';
    }
    toggleTypeFields();

    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const searchInput = document.getElementById('mapSearchInput');
    const searchBtn = document.getElementById('btnMapSearch');
    const searchStatus = document.getElementById('searchStatus');

    let startLat = parseFloat(latInput.value) || -6.38;
    let startLng = parseFloat(lngInput.value) || 108.20;

    const map = L.map('pickMap', { zoomControl: true }).setView([startLat, startLng], 15);
    
    // Satelit + Label Hybrid & Standard Vektor Layer Switcher
    const standardTile = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap contributors' });
    const satelliteTile = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { attribution: 'Esri Satellite' });
    const labelsTile = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', { attribution: 'CARTO' });
    const satelliteGroup = L.layerGroup([satelliteTile, labelsTile]);

    satelliteGroup.addTo(map);
    L.control.layers({ "Satelit": satelliteGroup, "Vektor": standardTile }, null, { position: 'topright' }).addTo(map);

    const marker = L.marker([startLat, startLng], { draggable: true }).addTo(map);

    function updateMarkerAndMap(lat, lng, zoom = 16) {
        lat = parseFloat(lat);
        lng = parseFloat(lng);
        if (isNaN(lat) || isNaN(lng)) return;

        latInput.value = lat.toFixed(6);
        lngInput.value = lng.toFixed(6);

        const newLatLng = new L.LatLng(lat, lng);
        marker.setLatLng(newLatLng);
        map.setView(newLatLng, zoom);
    }

    marker.on('dragend', () => {
        const p = marker.getLatLng();
        latInput.value = p.lat.toFixed(6);
        lngInput.value = p.lng.toFixed(6);
    });

    map.on('click', (e) => {
        marker.setLatLng(e.latlng);
        latInput.value = e.latlng.lat.toFixed(6);
        lngInput.value = e.latlng.lng.toFixed(6);
    });

    [latInput, lngInput].forEach(el => {
        el.addEventListener('input', () => {
            const lat = parseFloat(latInput.value);
            const lng = parseFloat(lngInput.value);
            if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                marker.setLatLng([lat, lng]);
                map.panTo([lat, lng]);
            }
        });
    });

    function parseCoords(text) {
        if (!text) return null;
        const match = text.match(/(-?\d+\.\d+)\s*[\s,]\s*(-?\d+\.\d+)/);
        if (match) {
            const lat = parseFloat(match[1]);
            const lng = parseFloat(match[2]);
            if (!isNaN(lat) && !isNaN(lng) && Math.abs(lat) <= 90 && Math.abs(lng) <= 180) {
                return { lat, lng };
            }
        }
        return null;
    }

    async function handleSearchOrPaste() {
        const query = searchInput.value.trim();
        if (!query) return;

        const parsed = parseCoords(query);
        if (parsed) {
            updateMarkerAndMap(parsed.lat, parsed.lng, 17);
            searchStatus.textContent = '✅ Koordinat berhasil diterapkan!';
            searchStatus.className = 'text-[11px] text-emerald-600 font-semibold';
            return;
        }

        searchStatus.textContent = '⏳ Mencari lokasi...';
        searchStatus.className = 'text-[11px] text-amber-600 font-medium';

        try {
            const searchTerms = query.toLowerCase().includes('indramayu') ? query : query + ', Indramayu';
            const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(searchTerms)}`);
            const data = await res.json();

            if (data && data.length > 0) {
                const lat = parseFloat(data[0].lat);
                const lng = parseFloat(data[0].lon);
                updateMarkerAndMap(lat, lng, 16);
                searchStatus.textContent = `✅ Ditemukan: ${data[0].display_name}`;
                searchStatus.className = 'text-[11px] text-emerald-600 font-medium';
            } else {
                searchStatus.textContent = '❌ Lokasi tidak ditemukan.';
                searchStatus.className = 'text-[11px] text-red-500 font-medium';
            }
        } catch (err) {
            searchStatus.textContent = '⚠️ Gagal terhubung ke layanan pencarian.';
            searchStatus.className = 'text-[11px] text-red-500 font-medium';
        }
    }

    searchBtn.addEventListener('click', handleSearchOrPaste);
    searchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            handleSearchOrPaste();
        }
    });

    document.getElementById('btnGeolocate').addEventListener('click', () => {
        if (!navigator.geolocation) return alert('Browser tidak mendukung geolocation.');
        searchStatus.textContent = '⏳ Meminta izin lokasi browser...';
        navigator.geolocation.getCurrentPosition(pos => {
            updateMarkerAndMap(pos.coords.latitude, pos.coords.longitude, 17);
            searchStatus.textContent = '✅ Lokasi saat ini berhasil diterapkan!';
            searchStatus.className = 'text-[11px] text-emerald-600 font-medium';
        }, () => {
            alert('Gagal mengambil lokasi browser.');
            searchStatus.textContent = '⚠️ Lokasi browser tidak dapat diakses.';
            searchStatus.className = 'text-[11px] text-red-500 font-medium';
        });
    });
</script>
@endpush