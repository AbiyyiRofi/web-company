@extends('layouts.admin')
@section('title', 'Riwayat Pengumuman')

@section('content')
<a href="{{ route('admin.announcements.index') }}" class="text-sm text-primary-600 hover:underline mb-4 inline-block">← Kembali</a>

<div class="space-y-3">
    @forelse($announcements as $ann)
        <div class="bg-white rounded-xl border p-4 opacity-80">
            <div class="flex items-center gap-3">
                @if($ann->image)
                    <img src="{{ asset('storage/'.$ann->image) }}" class="w-14 h-14 rounded-lg object-cover">
                @endif
                <div>
                    <div class="font-medium">{{ $ann->title }}</div>
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium bg-slate-200 text-slate-600">{{ $ann->status }}</span>
                    <div class="text-xs text-slate-400 mt-1">Dibuat: {{ $ann->created_at->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>
    @empty
        <p class="text-slate-400 text-center py-8">Belum ada riwayat pengumuman yang dihapus/kadaluarsa.</p>
    @endforelse
</div>
@endsection