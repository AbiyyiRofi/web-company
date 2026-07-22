@extends('layouts.admin')
@section('title', 'Publikasi')

@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div>
            <h3 class="font-semibold mb-3">Dokumen Publik</h3>
            <div class="bg-white rounded-xl border divide-y">
                @forelse($dokumenPublik as $doc)
                    <div class="p-4 flex items-center justify-between">
                        <div class="text-sm">{{ $doc->title }} <span class="text-xs text-slate-400">({{ strtoupper($doc->file_type) }})</span></div>
                        <div class="flex gap-3 text-sm">
                            <a href="{{ route('admin.publications.edit', $doc) }}" class="text-primary-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.publications.destroy', $doc) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="p-4 text-slate-400 text-sm">Belum ada dokumen.</p>
                @endforelse
            </div>
        </div>
        <div>
            <h3 class="font-semibold mb-3">Company Profile</h3>
            <div class="bg-white rounded-xl border divide-y">
                @forelse($companyProfiles as $doc)
                    <div class="p-4 flex items-center justify-between">
                        <div class="text-sm">{{ $doc->title }} <span class="text-xs text-slate-400">({{ strtoupper($doc->file_type) }})</span></div>
                        <div class="flex gap-3 text-sm">
                            <a href="{{ route('admin.publications.edit', $doc) }}" class="text-primary-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.publications.destroy', $doc) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="p-4 text-slate-400 text-sm">Belum ada company profile.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div>
        <div class="bg-white rounded-xl border p-6">
            <h3 class="font-semibold mb-3">Unggah Dokumen</h3>
            <form action="{{ route('admin.publications.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <select name="type" class="w-full border rounded-lg px-3 py-2 text-sm">
                    <option value="dokumen_publik">Dokumen Publik</option>
                    <option value="company_profile">Company Profile</option>
                </select>
                <input type="text" name="title" placeholder="Judul dokumen" class="w-full border rounded-lg px-3 py-2 text-sm" required>
                <input type="text" name="category" placeholder="Kategori (opsional)" class="w-full border rounded-lg px-3 py-2 text-sm">
                <input type="file" name="file" accept=".pdf,.doc,.docx" class="w-full text-sm" required>
                <button class="w-full px-4 py-2 bg-primary-600 text-white rounded-lg text-sm">Unggah</button>
            </form>
        </div>
    </div>
</div>
@endsection
