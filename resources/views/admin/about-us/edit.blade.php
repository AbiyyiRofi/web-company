@extends('layouts.admin')
@section('title', 'Konten Tentang Kami')

@section('content')
<form action="{{ route('admin.about-us.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-3xl">
    @csrf

    <div class="bg-white rounded-xl border p-6">
        <h3 class="font-semibold mb-4">Header / Poster</h3>
        @if($content->header_image)
            <img src="{{ asset('storage/'.$content->header_image) }}" class="w-full h-40 object-cover rounded-lg mb-3">
        @endif
        <label class="block text-sm font-medium mb-1">Gambar Header</label>
        <input type="file" name="header_image" accept="image/*" class="w-full text-sm mb-4">
        <label class="block text-sm font-medium mb-1">Caption Header (opsional)</label>
        <input type="text" name="header_caption" value="{{ old('header_caption', $content->header_caption) }}" class="w-full border rounded-lg px-3 py-2 text-sm">
    </div>

    <div class="bg-white rounded-xl border p-6">
        <h3 class="font-semibold mb-4">Sekilas PDAM</h3>
        <textarea name="sekilas_text" rows="6" class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('sekilas_text', $content->sekilas_text) }}</textarea>
    </div>

    <div class="bg-white rounded-xl border p-6">
        <h3 class="font-semibold mb-1">Ucapan Harapan &amp; Terima Kasih</h3>
        <p class="text-xs text-slate-400 mb-4">
            Nama &amp; jabatan di bawah foto akan otomatis diambil dari Direktur Utama pada menu "Dewan Direksi" — tidak perlu diisi manual di sini.
        </p>
        @if($content->harapan_photo)
            <img src="{{ asset('storage/'.$content->harapan_photo) }}" class="h-40 object-contain rounded-lg mb-3 bg-slate-50 p-2">
        @endif
        <label class="block text-sm font-medium mb-1">Foto Direktur Utama (setengah badan, background transparan/PNG disarankan)</label>
        <input type="file" name="harapan_photo" accept="image/*" class="w-full text-sm mb-4">
        <label class="block text-sm font-medium mb-1">Teks Ucapan Harapan &amp; Terima Kasih</label>
        <textarea name="harapan_text" rows="8" class="w-full border rounded-lg px-3 py-2 text-sm" placeholder="Kepada seluruh pemangku kepentingan yang kami hormati...">{{ old('harapan_text', $content->harapan_text) }}</textarea>
    </div>

    <div class="bg-white rounded-xl border p-6">
        <h3 class="font-semibold mb-4">Sejarah</h3>
        @if($content->sejarah_bg_image)
            <img src="{{ asset('storage/'.$content->sejarah_bg_image) }}" class="w-full h-32 object-cover rounded-lg mb-3">
        @endif
        <label class="block text-sm font-medium mb-1">Gambar Background Sejarah</label>
        <input type="file" name="sejarah_bg_image" accept="image/*" class="w-full text-sm mb-4">
        <label class="block text-sm font-medium mb-1">Teks Sejarah</label>
        <textarea name="sejarah_text" rows="6" class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('sejarah_text', $content->sejarah_text) }}</textarea>
    </div>

    <div class="bg-white rounded-xl border p-6 grid sm:grid-cols-2 gap-4">
        <div>
            <h3 class="font-semibold mb-2">Visi</h3>
            <textarea name="visi_text" rows="4" class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('visi_text', $content->visi_text) }}</textarea>
        </div>
        <div>
            <h3 class="font-semibold mb-2">Misi</h3>
            <textarea name="misi_text" rows="4" class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('misi_text', $content->misi_text) }}</textarea>
        </div>
    </div>

    <div class="bg-white rounded-xl border p-6">
        <h3 class="font-semibold mb-4">Struktur Organisasi</h3>
        <label class="block text-sm font-medium mb-1">Teks Informasi</label>
        <textarea name="struktur_text" rows="4" class="w-full border rounded-lg px-3 py-2 text-sm mb-4">{{ old('struktur_text', $content->struktur_text) }}</textarea>
        @if($content->struktur_image)
            <img src="{{ asset('storage/'.$content->struktur_image) }}" class="w-full h-40 object-cover rounded-lg mb-3">
        @endif
        <label class="block text-sm font-medium mb-1">Gambar Struktur</label>
        <input type="file" name="struktur_image" accept="image/*" class="w-full text-sm">
    </div>

    <button class="px-6 py-3 bg-primary-600 text-white rounded-lg text-sm font-semibold">Simpan Semua Perubahan</button>
</form>
@endsection
