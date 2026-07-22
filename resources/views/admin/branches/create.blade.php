@extends('layouts.admin')
@section('title', 'Tambah Cabang')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>#pickMap { height: 350px; width: 100%; }</style>
@endpush

@section('content')
<form action="{{ route('admin.branches.store') }}" method="POST" class="bg-white rounded-xl border p-6 max-w-2xl space-y-5">
    @csrf

    <div class="grid sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Nama Cabang</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-lg px-3 py-2 text-sm" required>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Jam Operasional</label>
            <input type="text" name="operational_hours" value="{{ old('operational_hours', 'Senin–Jumat, 07.30–16.00 WIB') }}" class="w-full border rounded-lg px-3 py-2 text-sm">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Alamat</label>
        <input type="text" name="address" value="{{ old('address') }}" class="w-full border rounded-lg px-3 py-2 text-sm" required>
    </div>

    <div class="grid sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">No. Telepon (opsional)</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">No. WhatsApp (buat tombol "Chat Sekarang")</label>
            <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="0812xxxxxxx" class="w-full border rounded-lg px-3 py-2 text-sm">
        </div>
    </div>

    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_head_office" value="1"> Tandai sebagai Kantor Pusat
    </label>

    <div>
        <div class="flex items-center justify-between mb-1">
            <label class="block text-sm font-medium">Titik Lokasi (geser marker biar presisi)</label>
            <button type="button" id="btnGeolocate" class="text-xs text-primary-600 hover:underline">📍 Pakai lokasi saat ini</button>
        </div>
        <div id="pickMap" class="rounded-lg overflow-hidden border"></div>
        <div class="grid grid-cols-2 gap-3 mt-2">
            <input type="text" id="latitudeDisplay" readonly class="border rounded-lg px-3 py-2 text-xs bg-slate-50 text-slate-500">
            <input type="text" id="longitudeDisplay" readonly class="border rounded-lg px-3 py-2 text-xs bg-slate-50 text-slate-500">
        </div>
        <input type="hidden" name="latitude" id="latitude" required>
        <input type="hidden" name="longitude" id="longitude" required>
    </div>

    <div class="flex gap-3">
        <button class="px-5 py-2 bg-primary-600 text-white rounded-lg text-sm">Simpan Cabang</button>
        <a href="{{ route('admin.branches.index') }}" class="px-5 py-2 border rounded-lg text-sm">Batal</a>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const map = L.map('pickMap').setView([-6.38, 108.20], 11);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap contributors' }).addTo(map);

    const marker = L.marker([-6.38, 108.20], { draggable: true }).addTo(map);

    function updateLatLng(lat, lng) {
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        document.getElementById('latitudeDisplay').value = 'Lat: ' + lat.toFixed(6);
        document.getElementById('longitudeDisplay').value = 'Lng: ' + lng.toFixed(6);
    }
    updateLatLng(-6.38, 108.20);

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
