@extends('layouts.admin')
@section('title', 'Tambah Poster Header')

@section('content')
<form action="{{ route('admin.header-slides.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border p-6 max-w-xl space-y-5">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-1">Judul (opsional, tampil di atas poster)</label>
        <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded-lg px-3 py-2 text-sm">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Tipe Media</label>
        <select name="media_type" id="mediaType" class="w-full border rounded-lg px-3 py-2 text-sm">
            <option value="image">Foto</option>
            <option value="video">Video</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">File</label>
        <input type="file" name="file" id="fileInput" accept="image/*" class="w-full text-sm" required>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Durasi Tampil (detik)</label>
        <input type="number" name="duration_seconds" id="durationInput" value="6" min="3" max="60" class="w-full border rounded-lg px-3 py-2 text-sm" required>
        <p class="text-xs text-slate-400 mt-1">Buat video, ini durasi progress bar berjalan (samakan dengan panjang video aslinya biar pas).</p>
    </div>

    <div class="flex gap-3">
        <button class="px-5 py-2 bg-primary-600 text-white rounded-lg text-sm">Simpan Poster</button>
        <a href="{{ route('admin.header-slides.index') }}" class="px-5 py-2 border rounded-lg text-sm">Batal</a>
    </div>
</form>

@push('scripts')
<script>
    document.getElementById('mediaType').addEventListener('change', function () {
        document.getElementById('fileInput').accept = this.value === 'video' ? 'video/*' : 'image/*';
    });

    // kalau upload video, coba baca durasi aslinya otomatis buat isi field durasi
    document.getElementById('fileInput').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file || document.getElementById('mediaType').value !== 'video') return;
        const video = document.createElement('video');
        video.preload = 'metadata';
        video.onloadedmetadata = function () {
            URL.revokeObjectURL(video.src);
            document.getElementById('durationInput').value = Math.round(video.duration);
        };
        video.src = URL.createObjectURL(file);
    });
</script>
@endpush
@endsection
