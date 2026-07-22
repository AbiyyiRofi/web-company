@extends('layouts.admin')
@section('title', 'Edit Pengadaan')

@section('content')
<form action="{{ route('admin.procurement.update', $procurement) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border p-6 max-w-2xl space-y-5">
    @csrf @method('PUT')

    <div>
        <label class="block text-sm font-medium mb-1">Judul Pengadaan</label>
        <input type="text" name="title" value="{{ old('title', $procurement->title) }}" class="w-full border rounded-lg px-3 py-2 text-sm" required>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Informasi / Deskripsi</label>
        <textarea name="description" rows="5" class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('description', $procurement->description) }}</textarea>
    </div>

    @if($procurement->documents->count())
        <div>
            <label class="block text-sm font-medium mb-2">Dokumen Saat Ini</label>
            <div class="space-y-2">
                @foreach($procurement->documents as $doc)
                    <label class="flex items-center justify-between bg-slate-50 rounded-lg p-3 text-sm">
                        <span>{{ $doc->title }} <span class="text-slate-400">({{ strtoupper($doc->file_type) }})</span></span>
                        <span class="flex items-center gap-1 text-red-600">
                            <input type="checkbox" name="remove_documents[]" value="{{ $doc->id }}"> Hapus
                        </span>
                    </label>
                @endforeach
            </div>
        </div>
    @endif

    <div>
        <label class="block text-sm font-medium mb-2">Tambah Dokumen Baru (opsional)</label>
        <div id="docFields" class="space-y-3"></div>
        <button type="button" id="addDocBtn" class="text-sm text-primary-600 hover:underline mt-2">+ Tambahkan dokumen lainnya</button>
    </div>

    <div class="flex gap-3">
        <button class="px-5 py-2 bg-primary-600 text-white rounded-lg text-sm">Update</button>
        <a href="{{ route('admin.procurement.index') }}" class="px-5 py-2 border rounded-lg text-sm">Batal</a>
    </div>
</form>

@push('scripts')
<script>
    function addDocField() {
        const wrap = document.createElement('div');
        wrap.className = 'grid grid-cols-2 gap-2 border rounded-lg p-3 relative';
        wrap.innerHTML = `
            <input type="text" name="doc_titles[]" placeholder="Judul dokumen" class="border rounded-lg px-3 py-2 text-sm">
            <input type="file" name="doc_files[]" accept=".pdf,.doc,.docx" class="text-sm">
            <button type="button" class="removeDocBtn absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 text-sm">×</button>`;
        wrap.querySelector('.removeDocBtn').addEventListener('click', () => wrap.remove());
        document.getElementById('docFields').appendChild(wrap);
    }
    document.getElementById('addDocBtn').addEventListener('click', addDocField);
    addDocField();
</script>
@endpush
@endsection
