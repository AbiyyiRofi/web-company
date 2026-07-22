@extends('layouts.admin')
@section('title', 'Pengumuman')

@section('content')
<div class="flex justify-between items-center mb-6">
    <a href="{{ route('admin.announcements.history') }}" class="text-sm text-primary-600 hover:underline">Lihat Riwayat →</a>
    <a href="{{ route('admin.announcements.create') }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm">+ Tambah Pengumuman</a>
</div>

<div class="space-y-3">
    @forelse($announcements as $ann)
        <div class="bg-white rounded-xl border p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                @if($ann->image)
                    <img src="{{ asset('storage/'.$ann->image) }}" class="w-14 h-14 rounded-lg object-cover">
                @endif
                <div>
                    <div class="font-medium">{{ $ann->title }}</div>
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium
                    {{ $ann->status === 'Aktif' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $ann->status === 'Terjadwal' ? 'bg-blue-100 text-blue-700' : '' }}
                    {{ $ann->status === 'Kadaluarsa' ? 'bg-slate-200 text-slate-500' : '' }}">
                    {{ $ann->status }}
                    </span>
                    <div class="text-xs text-slate-400">{{ $ann->created_at->format('d/m/Y') }} @if($ann->document_path) · 📎 ada dokumen @endif</div>
                </div>
            </div>
            <div class="flex gap-3 text-sm">
                <a href="{{ route('admin.announcements.edit', $ann) }}" class="text-primary-600 hover:underline">Edit</a>
                <form action="{{ route('admin.announcements.destroy', $ann) }}" method="POST" onsubmit="return confirm('Hapus pengumuman ini?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600 hover:underline">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-slate-400 text-center py-8">Belum ada pengumuman.</p>
    @endforelse
</div>
<div class="mt-6">{{ $announcements->links() }}</div>
@endsection
