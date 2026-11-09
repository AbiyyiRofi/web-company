@extends('layouts.admin')
@section('title', 'Kelola Sejarah Perusahaan')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Sejarah Perusahaan (Per Tahun)</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola lini masa sejarah perusahaan. Inputan tahun ini akan menjadi tombol pada slider sejarah di halaman depan.</p>
        </div>
        <button onclick="openCreateModal()" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-semibold transition flex items-center gap-2">
            <span>+</span> Tambah Sejarah
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    {{-- Card Background Lini Masa Sejarah --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4">
            <div>
                <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v13.5a1.5 1.5 0 001.5 1.5zm7.5-12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                    Background Lini Masa Sejarah
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Gambar latar belakang untuk bagian "Jejak Langkah / Sejarah Perusahaan" di halaman Tentang Kami.</p>
            </div>
            @if(isset($content) && $content->sejarah_bg_image)
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Gambar Kustom Aktif
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                    Background Standar (Gradasi Gelap)
                </span>
            @endif
        </div>

        <form action="{{ route('admin.history.background') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div class="relative w-full h-36 sm:h-48 rounded-xl overflow-hidden bg-slate-900 border border-slate-200 shadow-inner group">
                @if(isset($content) && $content->sejarah_bg_image)
                    <img src="{{ asset('storage/'.$content->sejarah_bg_image) }}" class="w-full h-full object-cover brightness-[0.45] transition duration-300 group-hover:scale-105">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-slate-900 via-primary-950 to-slate-900 flex flex-col items-center justify-center p-4 text-center">
                        <svg class="w-8 h-8 text-slate-600 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="text-xs text-slate-400 font-medium">Belum ada foto background kustom (saat ini menggunakan gradasi gelap standar)</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent flex items-end justify-between p-4 pointer-events-none">
                    <span class="text-xs text-white/90 font-medium drop-shadow">Simulasi Latar Belakang Sejarah Website</span>
                    <span class="text-[10px] text-slate-300 bg-black/40 px-2 py-0.5 rounded backdrop-blur">Rekomendasi Foto Melebar (Landscape)</span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <input type="file" name="sejarah_bg_image" accept="image/*" required class="flex-1 text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 transition file:cursor-pointer border rounded-lg p-1 bg-slate-50">
                <button type="submit" class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-xs font-semibold shadow-sm transition whitespace-nowrap flex items-center justify-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    Simpan Background
                </button>
            </div>
        </form>

        @if(isset($content) && $content->sejarah_bg_image)
            <div class="mt-3 pt-3 border-t border-slate-100 flex justify-end">
                <form action="{{ route('admin.history.background') }}" method="POST" onsubmit="return confirm('Hapus background kustom dan kembalikan ke tema gelap standar?')">
                    @csrf
                    <input type="hidden" name="remove_bg" value="1">
                    <button type="submit" class="text-xs text-red-600 hover:text-red-700 hover:underline flex items-center gap-1 font-medium transition">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus Background &amp; Kembalikan ke Standar
                    </button>
                </form>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead class="bg-slate-50 text-slate-700 font-semibold border-b border-slate-200">
                    <tr>
                        <th class="p-4 w-16 text-center">Urutan</th>
                        <th class="p-4 w-32">Tahun</th>
                        <th class="p-4 w-64">Judul / Sub-Judul</th>
                        <th class="p-4">Narasi / Isi Sejarah</th>
                        <th class="p-4 w-36 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($histories as $item)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-4 text-center font-medium text-slate-500">{{ $item->sort_order }}</td>
                            <td class="p-4 font-bold text-primary-700 whitespace-nowrap">{{ $item->year }}</td>
                            <td class="p-4 font-medium text-slate-800">{{ $item->title ?: '-' }}</td>
                            <td class="p-4 text-slate-600 text-xs sm:text-sm leading-relaxed max-w-md line-clamp-3">{{ $item->content }}</td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick='openEditModal(@json($item))' class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.history.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus sejarah tahun {{ $item->year }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-semibold transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400">Belum ada data sejarah per tahun. Silakan klik tombol "Tambah Sejarah".</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH / EDIT --}}
<div id="historyModal" class="fixed inset-0 bg-black/60 z-[9999] hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl relative" onclick="event.stopPropagation()">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 text-xl font-bold">×</button>
        <h3 id="modalTitle" class="text-lg font-bold text-slate-800 mb-4">Tambah Data Sejarah</h3>

        <form id="historyForm" method="POST" action="{{ route('admin.history.store') }}" class="space-y-4">
            @csrf
            <div id="methodField"></div>

            <div class="grid grid-cols-3 gap-3">
                <div class="col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tahun / Periode *</label>
                    <input type="text" name="year" id="inputYear" required placeholder="Contoh: 1932 atau 1957 - 1967" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Urutan</label>
                    <input type="number" name="sort_order" id="inputSortOrder" placeholder="1" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Judul / Sub-Judul (Opsional)</label>
                <input type="text" name="title" id="inputTitle" placeholder="Contoh: Sistem Penyediaan Air Minum (SPAM)" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Isi / Narasi Sejarah *</label>
                <textarea name="content" id="inputContent" rows="5" required placeholder="Tuliskan narasi sejarah lengkap untuk tahun ini..." class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 outline-none"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-semibold">Batal</button>
                <button type="submit" class="px-5 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-semibold">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const historyModal = document.getElementById('historyModal');
    const modalTitle = document.getElementById('modalTitle');
    const historyForm = document.getElementById('historyForm');
    const methodField = document.getElementById('methodField');
    const inputYear = document.getElementById('inputYear');
    const inputSortOrder = document.getElementById('inputSortOrder');
    const inputTitle = document.getElementById('inputTitle');
    const inputContent = document.getElementById('inputContent');

    const storeUrl = "{{ route('admin.history.store') }}";

    function openCreateModal() {
        modalTitle.textContent = 'Tambah Data Sejarah';
        historyForm.action = storeUrl;
        methodField.innerHTML = '';
        inputYear.value = '';
        inputSortOrder.value = '';
        inputTitle.value = '';
        inputContent.value = '';
        historyModal.classList.remove('hidden');
        historyModal.classList.add('flex');
    }

    function openEditModal(item) {
        modalTitle.textContent = 'Edit Data Sejarah (' + item.year + ')';
        historyForm.action = "/portal-internal/history/" + item.id;
        methodField.innerHTML = '@method("PUT")';
        inputYear.value = item.year || '';
        inputSortOrder.value = item.sort_order || '';
        inputTitle.value = item.title || '';
        inputContent.value = item.content || '';
        historyModal.classList.remove('hidden');
        historyModal.classList.add('flex');
    }

    function closeModal() {
        historyModal.classList.add('hidden');
        historyModal.classList.remove('flex');
    }
</script>
@endpush
@endsection
