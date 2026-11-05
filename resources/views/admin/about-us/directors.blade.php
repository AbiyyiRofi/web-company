@extends('layouts.admin')
@section('title', 'Jajaran Direksi & Kuasa Pemilik Modal')

@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-4">
        @foreach(['direksi' => 'Jajaran Direksi', 'pemilik_modal' => 'Kuasa Pemilik Modal'] as $type => $label)
            <h3 class="font-semibold text-lg mt-2">{{ $label }}</h3>
            @forelse($directors->where('type', $type) as $d)
                <div class="bg-white rounded-xl border p-4 flex gap-4">
                    <img src="{{ $d->photo ? asset('storage/'.$d->photo) : 'https://placehold.co/100x120/e2e8f0/64748b?text=Foto' }}" class="w-20 h-24 object-cover rounded-lg shrink-0">
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold">{{ $d->name }}</div>
                        <div class="text-primary-600 text-sm">{{ $d->position }}</div>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $d->description }}</p>
                        <div class="mt-2 flex gap-3 text-sm">
                            <button type="button" onclick="editDirector({{ $d->id }})" class="text-primary-600 hover:underline">Edit</button>
                            <form action="{{ route('admin.directors.destroy', $d) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-slate-400 text-sm">Belum ada data.</p>
            @endforelse
        @endforeach
    </div>

    <div>
        <div class="bg-white rounded-xl border p-6 sticky top-6">
            <h3 id="formTitle" class="font-semibold mb-4">Tambah Direksi / Pemilik Modal</h3>
            <form id="directorForm" action="{{ route('admin.directors.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf

                <select name="type" class="w-full border rounded-lg px-3 py-2 text-sm">
                    <option value="direksi">Jajaran Direksi</option>
                    <option value="pemilik_modal">Kuasa Pemilik Modal</option>
                </select>
                <input type="text" name="name" id="fieldName" placeholder="Nama" class="w-full border rounded-lg px-3 py-2 text-sm" required>
                <input type="text" name="position" id="fieldPosition" placeholder="Jabatan" class="w-full border rounded-lg px-3 py-2 text-sm" required>
                <textarea name="description" id="fieldDescription" rows="4" placeholder="Teks informasi/profil singkat" class="w-full border rounded-lg px-3 py-2 text-sm"></textarea>
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Foto</label>
                    <input type="file" name="photo" accept="image/*" class="w-full text-sm">
                </div>
                <div class="flex gap-2">
                    <button class="flex-1 px-4 py-2 bg-primary-600 text-white rounded-lg text-sm">Simpan</button>
                    <button type="button" onclick="resetForm()" class="px-4 py-2 border rounded-lg text-sm">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const directorsData = @json($directors->keyBy('id'));
    const storeUrl = "{{ route('admin.directors.store') }}";

    function editDirector(id) {
        const d = directorsData[id];
        // Route update didaftarin sebagai POST biasa (bukan PUT), jadi TIDAK perlu _method spoofing.
        document.getElementById('directorForm').action = `/portal-internal/directors/${id}`;
        document.getElementById('fieldName').value = d.name;
        document.getElementById('fieldPosition').value = d.position;
        document.getElementById('fieldDescription').value = d.description || '';
        document.querySelector('select[name=type]').value = d.type;
        document.getElementById('formTitle').textContent = 'Edit: ' + d.name;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function resetForm() {
        document.getElementById('directorForm').action = storeUrl;
        document.getElementById('directorForm').reset();
        document.getElementById('formTitle').textContent = 'Tambah Direksi / Pemilik Modal';
    }
</script>
@endpush
@endsection
