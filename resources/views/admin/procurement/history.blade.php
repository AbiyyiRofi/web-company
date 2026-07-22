@extends('layouts.admin')
@section('title', 'Riwayat Pengadaan')

@section('content')
<a href="{{ route('admin.procurement.index') }}" class="text-sm text-primary-600 hover:underline mb-4 inline-block">← Kembali</a>

<div class="space-y-3">
    @forelse($procurements as $p)
        <div class="bg-white rounded-xl border p-4 opacity-80">
            <div class="font-medium">{{ $p->title }}</div>
            <div class="text-xs text-slate-400 mt-1">
                Dibuat: {{ $p->created_at->format('d/m/Y') }} · Dihapus: {{ $p->deleted_at->format('d/m/Y') }} · {{ $p->documents->count() }} dokumen
            </div>
        </div>
    @empty
        <p class="text-slate-400 text-center py-8">Belum ada riwayat pengadaan yang dihapus.</p>
    @endforelse
</div>
@endsection