@extends('layouts.admin')
@section('title', 'Edit Lokasi')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>#pickMap { height: 350px; width: 100%; }</style>
@endpush

@section('content')
<form action="{{ route('admin.branches.update', $branch) }}" method="POST" class="bg-white rounded-xl border p-6 max-w-2xl space-y-5">
    @csrf @method('PUT')

    <div>
        <label class="block text-sm font-medium mb-2">Jenis Lokasi</label>
        <div class="flex gap-4">
            <label class="flex items-center gap-2 text-sm">
                <input type="radio" name="type" value="cabang" onchange="toggleTypeFields()" {{ $branch->type === 'cabang' ? 'checked' : '' }}> Cabang / Unit
            </label>
            <label class="flex items-center gap-2 text-sm">
                <input type="radio" name="type" value="ipa" onchange="toggleTypeFields()" {{ $branch->type === 'ipa' ? 'checked' : '' }}> IPA (Instalasi Pengolahan Air)
            </label>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1" id="nameLabel">Nama</label>
        <input type="text" name="name" value="{{ old('name', $branch->name) }}" class="w-full border rounded-lg px-3 py-2 text-sm" required>
    </div>

    <div id="cabangFields" class="space-y-5">
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Jam Operasional</label>
                <input type="text" name="operational_hours" value="{{ old('operational_hours', $branch->operational_hours) }}" class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">No. WhatsApp</label>
                <input type="text" name="whatsapp" value="{{ old('whatsapp', $branch->whatsapp) }}" class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">No. Telepon</label>
            <input type="text" name="phone" value="{{ old('phone', $branch->phone) }}" class="w-full border rounded-lg px-3 py-2 text-sm">
        </div>
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_head_office" value="1" {{ $branch->is_head_office ? 'checked' : '' }}> Tandai sebagai Kantor Pusat
        </label>
    </div>

    <div id="ipaFields" class="space-y-5 hidden">
        <div>
            <label class="block text-sm font-medium mb-1">1. Kapasitas Terpasang</label>
            <textarea name="kapasitas_terpasang_text" rows="5" class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('kapasitas_terpasang_text', $branch->kapasitas_terpasang_text) }}</textarea>
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">2. Kapasitas Produksi</label>
                <input type="text" name="kapasitas_produksi" value="{{ old('kapasitas_produksi', $branch->kapasitas_produksi) }}" class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">3. Idle Capacity</label>
                <input type="text" name="idle_capacity" value="{{ old('idle_capacity', $branch->idle_capacity) }}" class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Alamat</label>
        <input type="text" name="address" value="{{ old('address', $branch->address) }}" class="w-full border rounded-lg px-3 py-2 text-sm" required>
    </div>

    <div>
        <div class="flex items-center justify-between mb-1">
            <label class="block text-sm font-medium">Titik Lokasi</label>
            <button type="button" id="btnGeolocate" class="text-xs text-primary-600 hover:underline">📍 Pakai lokasi saat ini</button>
        </div>
        <div id="pickMap" class="rounded-lg overflow-hidden border"></div>
        <div class="grid grid-cols-2 gap-3 mt-2">
            <input type="text" id="latitudeDisplay" readonly class="border rounded-lg px-3 py-2 text-xs bg-slate-50 text-slate-500">
            <input type="text" id="longitudeDisplay" readonly class="border rounded-lg px-3 py-2 text-xs bg-slate-50 text-slate-500">
        </div>
        <input type="hidden" name="latitude" id="latitude" value="{{ $branch->latitude }}" required>
        <input type="hidden" name="longitude" id="longitude" value="{{ $branch->longitude }}" required>
    </div>

    <div class="flex gap-3">
        <button class="px-5 py-2 bg-primary-600 text-white rounded-lg text-sm">Simpan Perubahan</button>
        <a href="{{ route('admin.branches.index') }}" class="px-5 py-2 border rounded-lg text-sm">Batal</a>
    </div>
</form>
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

    const startLat = {{ $branch->latitude }};
    const startLng = {{ $branch->longitude }};

    const map = L.map('pickMap').setView([startLat, startLng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap contributors' }).addTo(map);

    const marker = L.marker([startLat, startLng], { draggable: true }).addTo(map);

    function updateLatLng(lat, lng) {
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        document.getElementById('latitudeDisplay').value = 'Lat: ' + lat.toFixed(6);
        document.getElementById('longitudeDisplay').value = 'Lng: ' + lng.toFixed(6);
    }
    updateLatLng(startLat, startLng);

    marker.on('dragend', () => { const p = marker.getLatLng(); updateLatLng(p.lat, p.lng); });
    map.on('click', (e) => { marker.setLatLng(e.latlng); updateLatLng(e.latlng.lat, e.latlng.lng); });

    document.getElementById('btnGeolocate').addEventListener('click', () => {
        if (!navigator.geolocation) return alert('Browser tidak mendukung geolocation.');
        navigator.geolocation.getCurrentPosition(pos => {
            const latlng = [pos.coords.latitude, pos.coords.longitude];
            map.setView(latlng, 17);
            marker.setLatLng(latlng);
            updateLatLng(latlng[0], latlng[1]);
        }, () => alert('Gagal mengambil lokasi. Geser marker manual.'));
    });
</script>
@endpush