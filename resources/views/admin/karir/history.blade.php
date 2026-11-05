@extends('layouts.admin')
@section('title', 'Riwayat Poster Karir')

@section('content')
<div class="flex items-center justify-between mb-4">
    <a href="{{ route('admin.karir.edit') }}" class="text-sm text-primary-600 hover:underline">← Kembali ke Pengaturan Karir</a>
    <span class="text-xs text-slate-400">Menampilkan poster yang Kadaluarsa atau Dihapus</span>
</div>

<div class="space-y-3">
    @forelse($posters as $poster)
        <div class="bg-white rounded-xl border p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('storage/'.$poster->image) }}" class="w-16 h-16 object-cover rounded-lg opacity-80">
                <div class="text-sm">
                    <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold
                        {{ $poster->status === 'Kadaluarsa' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-slate-200 text-slate-600' }}">
                        {{ $poster->status }}
                    </span>
                    <div class="text-slate-600 mt-1 font-medium">
                        Tayang: {{ $poster->start_date?->format('d/m/Y') ?? 'Tanpa batas mulai' }} — {{ $poster->end_date?->format('d/m/Y') ?? 'Tanpa batas selesai' }}
                    </div>
                    <div class="text-xs text-slate-400 mt-0.5">Diupload: {{ $poster->created_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
            @if(!$poster->trashed())
                <form action="{{ route('admin.karir.posters.destroy', $poster) }}" method="POST" onsubmit="return confirm('Pindahkan poster kadaluarsa ini ke daftar Dihapus?')">
                    @csrf @method('DELETE')
                    <button class="text-xs text-red-600 hover:underline px-3 py-1.5 rounded-lg border border-red-200 hover:bg-red-50">Tandai Dihapus</button>
                </form>
            @endif
        </div>
    @empty
        <p class="text-slate-400 text-center py-8">Belum ada riwayat poster yang kadaluarsa atau dihapus.</p>
    @endforelse
</div>
@endsection