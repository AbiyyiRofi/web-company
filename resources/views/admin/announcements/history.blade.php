@extends('layouts.admin')
@section('title', 'Riwayat Pengumuman')

@section('content')
<div class="flex items-center justify-between mb-4">
    <a href="{{ route('admin.announcements.index') }}" class="text-sm text-primary-600 hover:underline">← Kembali ke Pengumuman</a>
    <span class="text-xs text-slate-400">Menampilkan pengumuman Kadaluarsa atau Dihapus</span>
</div>

<div class="space-y-3">
    @forelse($announcements as $ann)
        <div class="bg-white rounded-xl border p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                @if($ann->image)
                    <img src="{{ asset('storage/'.$ann->image) }}" class="w-14 h-14 rounded-lg object-cover opacity-80">
                @endif
                <div>
                    <div class="font-medium text-slate-800">{{ $ann->title }}</div>
                    <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold mt-1
                        {{ $ann->status === 'Kadaluarsa' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-slate-200 text-slate-600' }}">
                        {{ $ann->status }}
                    </span>
                    <div class="text-xs text-slate-400 mt-1">Dibuat: {{ $ann->created_at->format('d/m/Y') }}</div>
                </div>
            </div>
            @if(!$ann->trashed())
                <form action="{{ route('admin.announcements.destroy', $ann) }}" method="POST" onsubmit="return confirm('Pindahkan pengumuman kadaluarsa ini ke daftar Dihapus?')">
                    @csrf @method('DELETE')
                    <button class="text-xs text-red-600 hover:underline px-3 py-1.5 rounded-lg border border-red-200 hover:bg-red-50">Tandai Dihapus</button>
                </form>
            @endif
        </div>
    @empty
        <p class="text-slate-400 text-center py-8">Belum ada riwayat pengumuman yang kadaluarsa atau dihapus.</p>
    @endforelse
</div>
@endsection