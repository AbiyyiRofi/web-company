@extends('layouts.admin')
@section('title', 'Tambah Poster Header')

@section('content')
<div class="max-w-2xl">
    <div class="mb-5">
        <a href="{{ route('admin.header-slides.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-slate-800">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Poster
        </a>
    </div>

    @if($errors->any())
        <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.header-slides.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Judul Slide (opsional)</label>
            <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Kunjungan Direksi / Promo Banyu Digital" class="w-full border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            <p class="text-xs text-slate-400 mt-1">Judul ini akan ditampilkan di tombol label navigasi slider pada beranda.</p>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Tipe Media</label>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <label class="relative flex flex-col p-3 border-2 rounded-xl cursor-pointer transition hover:bg-slate-50 media-option-card">
                    <input type="radio" name="media_type" value="image" class="sr-only" {{ old('media_type', 'image') === 'image' ? 'checked' : '' }}>
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="font-medium text-sm text-slate-800">Foto / Gambar</span>
                    </div>
                    <span class="text-xs text-slate-400">Upload file JPG, PNG, WebP</span>
                </label>

                <label class="relative flex flex-col p-3 border-2 rounded-xl cursor-pointer transition hover:bg-slate-50 media-option-card">
                    <input type="radio" name="media_type" value="youtube" class="sr-only" {{ old('media_type') === 'youtube' ? 'checked' : '' }}>
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        <span class="font-medium text-sm text-slate-800">Link YouTube</span>
                    </div>
                    <span class="text-xs text-emerald-600 font-medium">Rekomendasi video besar</span>
                </label>

                <label class="relative flex flex-col p-3 border-2 rounded-xl cursor-pointer transition hover:bg-slate-50 media-option-card">
                    <input type="radio" name="media_type" value="video" class="sr-only" {{ old('media_type') === 'video' ? 'checked' : '' }}>
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <span class="font-medium text-sm text-slate-800">Video Langsung</span>
                    </div>
                    <span class="text-xs text-slate-400">File lokal (MP4/WebM kecil)</span>
                </label>
            </div>
        </div>

        <!-- Section Link YouTube -->
        <div id="youtubeSection" class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-3">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Link URL Video YouTube <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-red-500">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </div>
                    <input type="text" name="youtube_url" id="youtubeUrlInput" value="{{ old('youtube_url') }}" placeholder="https://www.youtube.com/watch?v=... atau https://youtu.be/..." class="w-full pl-10 pr-3.5 py-2.5 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <p class="text-xs text-slate-500 mt-1.5">
                    💡 <strong>Tips:</strong> Video akan otomatis diputar di latar belakang header beranda secara autoplay (tanpa suara & looping).
                </p>
            </div>

            <!-- YouTube Live Preview -->
            <div id="youtubePreviewBox" class="hidden mt-3 p-3 bg-white rounded-lg border border-slate-200">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-2">Pratinjau YouTube:</span>
                <div class="flex items-center gap-3">
                    <img id="ytThumb" src="" alt="Thumbnail" class="w-28 h-16 object-cover rounded-md bg-slate-100 border">
                    <div class="flex-1 min-w-0">
                        <div id="ytVideoId" class="text-xs font-mono font-semibold text-slate-800"></div>
                        <div class="text-xs text-green-600 flex items-center gap-1 mt-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Video terdeteksi valid
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Upload File (Gambar / Video Manual) -->
        <div id="fileSection" class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-3">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1" id="fileLabel">Upload File <span class="text-red-500">*</span></label>
                <input type="file" name="file" id="fileInput" accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 cursor-pointer">
                <div id="videoFileNote" class="hidden mt-2 p-3 bg-amber-50 border border-amber-200 rounded-lg text-amber-800 text-xs">
                    ⚠️ <strong>Perhatian:</strong> Upload video langsung dibatasi oleh server (maksimal ~2MB). Jika video Anda berukuran lebih besar, silakan gunakan opsi <strong>Link YouTube</strong>.
                </div>
                <p id="imageFileNote" class="text-xs text-slate-400 mt-1">Format didukung: JPG, PNG, WEBP (disarankan resolusi 1920x800 px).</p>
            </div>
        </div>

        <!-- Section Durasi -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Durasi Tampil Slide (detik)</label>
            <div class="flex items-center gap-3">
                <input type="number" name="duration_seconds" id="durationInput" value="{{ old('duration_seconds', 6) }}" min="3" max="300" class="w-32 border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500" required>
                <span class="text-sm text-slate-500">detik</span>
            </div>
            <p class="text-xs text-slate-400 mt-1" id="durationHint">
                Lama waktu slide ini ditampilkan di beranda sebelum berpindah ke slide berikutnya.
            </p>
        </div>

        <div class="flex items-center gap-3 pt-3 border-t">
            <button type="submit" class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                Simpan Poster
            </button>
            <a href="{{ route('admin.header-slides.index') }}" class="px-5 py-2.5 border border-slate-300 hover:bg-slate-50 text-slate-700 rounded-lg text-sm font-medium transition">
                Batal
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const radioButtons = document.querySelectorAll('input[name="media_type"]');
    const cards = document.querySelectorAll('.media-option-card');
    const youtubeSection = document.getElementById('youtubeSection');
    const fileSection = document.getElementById('fileSection');
    const fileInput = document.getElementById('fileInput');
    const fileLabel = document.getElementById('fileLabel');
    const videoFileNote = document.getElementById('videoFileNote');
    const imageFileNote = document.getElementById('imageFileNote');
    const youtubeUrlInput = document.getElementById('youtubeUrlInput');
    const youtubePreviewBox = document.getElementById('youtubePreviewBox');
    const ytThumb = document.getElementById('ytThumb');
    const ytVideoId = document.getElementById('ytVideoId');
    const durationInput = document.getElementById('durationInput');
    const durationHint = document.getElementById('durationHint');

    function parseYouTubeId(url) {
        if (!url) return null;
        url = url.trim();
        if (/^[a-zA-Z0-9_-]{11}$/.test(url)) return url;
        const reg = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|shorts)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i;
        const match = url.match(reg);
        return match ? match[1] : null;
    }

    function updatePreview() {
        const id = parseYouTubeId(youtubeUrlInput.value);
        if (id) {
            ytThumb.src = `https://img.youtube.com/vi/${id}/hqdefault.jpg`;
            ytVideoId.textContent = `ID Video: ${id}`;
            youtubePreviewBox.classList.remove('hidden');
        } else {
            youtubePreviewBox.classList.add('hidden');
        }
    }

    youtubeUrlInput.addEventListener('input', updatePreview);
    youtubeUrlInput.addEventListener('paste', () => setTimeout(updatePreview, 50));

    function syncType() {
        const selected = document.querySelector('input[name="media_type"]:checked').value;

        // Styling radio cards
        cards.forEach(card => {
            const input = card.querySelector('input');
            if (input.checked) {
                card.classList.add('border-primary-600', 'bg-primary-50/40');
                card.classList.remove('border-slate-200');
            } else {
                card.classList.remove('border-primary-600', 'bg-primary-50/40');
                card.classList.add('border-slate-200');
            }
        });

        if (selected === 'youtube') {
            youtubeSection.classList.remove('hidden');
            fileSection.classList.add('hidden');
            fileInput.removeAttribute('required');
            fileInput.value = '';
            youtubeUrlInput.setAttribute('required', 'required');
            durationHint.textContent = 'Durasi tayang video YouTube (contoh: 15 - 30 detik) sebelum beralih ke slide berikutnya.';
            if (durationInput.value == 6) durationInput.value = 15;
            updatePreview();
        } else if (selected === 'video') {
            youtubeSection.classList.add('hidden');
            fileSection.classList.remove('hidden');
            youtubeUrlInput.removeAttribute('required');
            fileInput.setAttribute('required', 'required');
            fileInput.accept = 'video/mp4,video/webm,video/quicktime';
            fileLabel.innerHTML = 'Upload File Video <span class="text-red-500">*</span>';
            videoFileNote.classList.remove('hidden');
            imageFileNote.classList.add('hidden');
            durationHint.textContent = 'Untuk file video manual, durasi otomatis terisi dari panjang video (atau atur manual).';
        } else {
            // image
            youtubeSection.classList.add('hidden');
            fileSection.classList.remove('hidden');
            youtubeUrlInput.removeAttribute('required');
            fileInput.setAttribute('required', 'required');
            fileInput.accept = 'image/jpeg,image/png,image/webp';
            fileLabel.innerHTML = 'Upload File Gambar / Foto <span class="text-red-500">*</span>';
            videoFileNote.classList.add('hidden');
            imageFileNote.classList.remove('hidden');
            durationHint.textContent = 'Durasi tampil slide foto (standar 6 detik).';
            if (durationInput.value > 15) durationInput.value = 6;
        }
    }

    radioButtons.forEach(r => r.addEventListener('change', syncType));
    syncType();

    // Otomatis baca durasi file video manual jika diupload
    fileInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        const selected = document.querySelector('input[name="media_type"]:checked').value;
        if (!file || selected !== 'video') return;
        const video = document.createElement('video');
        video.preload = 'metadata';
        video.onloadedmetadata = function () {
            URL.revokeObjectURL(video.src);
            durationInput.value = Math.min(Math.round(video.duration), 300);
        };
        video.src = URL.createObjectURL(file);
    });
</script>
@endpush
@endsection
