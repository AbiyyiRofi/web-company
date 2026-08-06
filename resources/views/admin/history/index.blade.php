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
