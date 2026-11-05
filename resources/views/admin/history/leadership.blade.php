@extends('layouts.admin')
@section('title', 'Kelola Sejarah Kepemimpinan')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Sejarah Kepemimpinan (Direktur Masa Jabatan Dahulu)</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola daftar pimpinan/direktur periode dahulu yang tampil pada card carousel di atas timeline sejarah perusahaan.</p>
        </div>
        <button onclick="openCreateModal()" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-semibold transition flex items-center gap-2">
            <span>+</span> Tambah Pimpinan
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
                        <th class="p-4 w-24">Foto</th>
                        <th class="p-4">Nama Direktur</th>
                        <th class="p-4 w-44">Masa Jabatan / Tahun</th>
                        <th class="p-4 w-40">Jabatan</th>
                        <th class="p-4 w-32 text-center">Durasi (ms)</th>
                        <th class="p-4 w-36 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($leadershipHistories as $item)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-4 text-center font-medium text-slate-500">{{ $item->sort_order }}</td>
                            <td class="p-4">
                                <div class="w-12 h-14 rounded-lg bg-slate-100 overflow-hidden border border-slate-200 shrink-0">
                                    <img src="{{ $item->photo ? asset('storage/' . $item->photo) : 'https://placehold.co/100x120/e2e8f0/64748b?text=Foto' }}" class="w-full h-full object-cover">
                                </div>
                            </td>
                            <td class="p-4 font-bold text-slate-800">{{ $item->name }}</td>
                            <td class="p-4 font-semibold text-primary-700 whitespace-nowrap">{{ $item->period }}</td>
                            <td class="p-4 text-slate-600 text-xs sm:text-sm">{{ $item->position ?: 'Direktur Utama' }}</td>
                            <td class="p-4 text-center text-xs text-slate-500">{{ $item->duration ?: 6000 }} ms</td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick='openEditModal(@json($item))' class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.leadership-history.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data kepemimpinan {{ $item->name }}?')">
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
                            <td colspan="7" class="p-8 text-center text-slate-400">Belum ada data sejarah kepemimpinan. Silakan klik tombol "Tambah Pimpinan".</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH / EDIT --}}
<div id="leadershipModal" class="fixed inset-0 bg-black/60 z-[9999] hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl relative" onclick="event.stopPropagation()">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 text-xl font-bold">×</button>
        <h3 id="modalTitle" class="text-lg font-bold text-slate-800 mb-4">Tambah Data Pimpinan</h3>

        <form id="leadershipForm" method="POST" action="{{ route('admin.leadership-history.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div id="methodField"></div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Direktur / Pimpinan *</label>
                <input type="text" name="name" id="inputName" required placeholder="Contoh: H. Mohammad Yasin, S.E." class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Masa Jabatan / Tahun *</label>
                    <input type="text" name="period" id="inputPeriod" required placeholder="Contoh: 2015 - 2020" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jabatan</label>
                    <input type="text" name="position" id="inputPosition" placeholder="Direktur Utama" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Urutan Tampil</label>
                    <input type="number" name="sort_order" id="inputSortOrder" placeholder="1" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Waktu Tayang (ms)</label>
                    <input type="number" name="duration" id="inputDuration" placeholder="6000 (6 detik)" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Foto Direktur (Maks 3 MB)</label>
                <input type="file" name="photo" id="inputPhoto" accept="image/*" class="w-full border rounded-lg px-3 py-1.5 text-xs text-slate-600 focus:ring-2 focus:ring-primary-500 outline-none">
                <div id="photoPreviewContainer" class="mt-2 hidden">
                    <img id="photoPreview" class="h-20 w-16 object-cover rounded-lg border">
                </div>
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
    const leadershipModal = document.getElementById('leadershipModal');
    const modalTitle = document.getElementById('modalTitle');
    const leadershipForm = document.getElementById('leadershipForm');
    const methodField = document.getElementById('methodField');
    const inputName = document.getElementById('inputName');
    const inputPeriod = document.getElementById('inputPeriod');
    const inputPosition = document.getElementById('inputPosition');
    const inputSortOrder = document.getElementById('inputSortOrder');
    const inputDuration = document.getElementById('inputDuration');
    const photoPreviewContainer = document.getElementById('photoPreviewContainer');
    const photoPreview = document.getElementById('photoPreview');

    const storeUrl = "{{ route('admin.leadership-history.store') }}";

    function openCreateModal() {
        modalTitle.textContent = 'Tambah Data Pimpinan';
        leadershipForm.action = storeUrl;
        methodField.innerHTML = '';
        inputName.value = '';
        inputPeriod.value = '';
        inputPosition.value = 'Direktur Utama';
        inputSortOrder.value = '';
        inputDuration.value = '6000';
        photoPreviewContainer.classList.add('hidden');
        leadershipModal.classList.remove('hidden');
        leadershipModal.classList.add('flex');
    }

    function openEditModal(item) {
        modalTitle.textContent = 'Edit Data Pimpinan (' + item.name + ')';
        leadershipForm.action = "/portal-internal/leadership-history/" + item.id;
        methodField.innerHTML = '@method("PUT")';
        inputName.value = item.name || '';
        inputPeriod.value = item.period || '';
        inputPosition.value = item.position || 'Direktur Utama';
        inputSortOrder.value = item.sort_order || '';
        inputDuration.value = item.duration || 6000;
        if (item.photo) {
            photoPreview.src = "/storage/" + item.photo;
            photoPreviewContainer.classList.remove('hidden');
        } else {
            photoPreviewContainer.classList.add('hidden');
        }
        leadershipModal.classList.remove('hidden');
        leadershipModal.classList.add('flex');
    }

    function closeModal() {
        leadershipModal.classList.add('hidden');
        leadershipModal.classList.remove('flex');
    }
</script>
@endpush
@endsection
