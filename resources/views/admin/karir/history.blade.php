@extends('layouts.admin')
@section('title', 'Riwayat Poster Karir')

@section('content')
<a href="{{ route('admin.karir.edit') }}" class="text-sm text-primary-600 hover:underline mb-4 inline-block">← Kembali</a>

<div class="space-y-3">
    @forelse($posters as $poster)
        <div class="bg-white rounded-xl border p-4 flex items-center gap-3">
            <img src="{{ asset('storage/'.$poster->image) }}" class="w-16 h-16 object-cover rounded-lg opacity-70">
            <div class="text-sm">
                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium bg-slate-200 text-slate-600">{{ $poster->status }}</span>
                <div class="text-slate-500 mt-1">
                    Tayang: {{ $poster->start_date?->format('d/m/Y') ?? '-' }} — {{ $poster->end_date?->format('d/m/Y') ?? '-' }}
                </div>
                <div class="text-xs text-slate-400">Diupload: {{ $poster->created_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    @empty
        <p class="text-slate-400 text-center py-8">Belum ada riwayat poster yang dihapus/kadaluarsa.</p>
    @endforelse
</div>
@endsection