@extends('layouts.admin')
@section('title', 'Konten Tentang Kami')

@section('content')
<form action="{{ route('admin.about-us.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-3xl">
    @csrf

    <div class="bg-white rounded-xl border p-6 space-y-4">
        <h3 class="font-semibold text-slate-800">Header / Poster Halaman</h3>

        @include('partials.header-image-adjuster', [
            'content' => $content,
            'label' => 'Gambar Header Tentang Kami',
            'pageTitle' => 'Tentang Kami',
        ])

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Caption Header (opsional)</label>
            <input type="text" name="header_caption" value="{{ old('header_caption', $content->header_caption) }}" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500">
        </div>
    </div>

    <div class="bg-white rounded-xl border p-6">
        <h3 class="font-semibold mb-4">Sekilas PDAM</h3>
        <textarea name="sekilas_text" rows="6" class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('sekilas_text', $content->sekilas_text) }}</textarea>
    </div>

    <div class="bg-white rounded-xl border p-6">
        <h3 class="font-semibold mb-1">Ucapan Harapan &amp; Terima Kasih</h3>
        <p class="text-xs text-slate-400 mb-4">
            Nama &amp; jabatan di bawah foto akan otomatis diambil dari Direktur Utama pada menu "Jajaran Direksi" — tidak perlu diisi manual di sini.
        </p>
        @if($content->harapan_photo)
            <img src="{{ asset('storage/'.$content->harapan_photo) }}" class="h-40 object-contain rounded-lg mb-3 bg-slate-50 p-2">
        @endif
        <label class="block text-sm font-medium mb-1">Foto Direktur Utama (setengah badan, background transparan/PNG disarankan)</label>
        <input type="file" name="harapan_photo" accept="image/*" class="w-full text-sm mb-4">
        <label class="block text-sm font-medium mb-1">Teks Ucapan Harapan &amp; Terima Kasih</label>
        <textarea name="harapan_text" rows="8" class="w-full border rounded-lg px-3 py-2 text-sm" placeholder="Kepada seluruh pemangku kepentingan yang kami hormati...">{{ old('harapan_text', $content->harapan_text) }}</textarea>
    </div>

    {{-- Notice: Pengelolaan Sejarah Terpusat di Menu Sejarah (Per Tahun) --}}
    <div class="bg-gradient-to-r from-sky-50 to-blue-50 rounded-xl border border-sky-200 p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-sky-500 text-white flex items-center justify-center shrink-0 shadow-sm text-lg font-bold">
                📜
            </div>
            <div>
                <h4 class="font-bold text-slate-800 text-sm">Sejarah &amp; Background Perusahaan</h4>
                <p class="text-xs text-slate-600 mt-0.5 leading-relaxed">
                    Lini masa sejarah per tahun serta gambar background bagian sejarah kini dikelola terpusat di menu <strong>Sejarah (Per Tahun)</strong> agar rapi dan tidak terpisah.
                </p>
            </div>
        </div>
        <a href="{{ route('admin.history.index') }}" class="shrink-0 px-4 py-2 bg-white text-primary-700 hover:bg-primary-50 border border-primary-200 rounded-lg text-xs font-semibold shadow-sm transition inline-flex items-center gap-1.5">
            Kelola Sejarah →
        </a>
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
