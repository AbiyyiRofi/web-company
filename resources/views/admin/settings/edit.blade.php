@extends('layouts.admin')
@section('title', 'Pengaturan Logo')

@section('content')
<div class="max-w-xl">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="admin-card p-6 space-y-5">
        @csrf
        <div class="flex items-center gap-4">
            @if($setting->logo)
                <div class="h-20 w-20 flex items-center justify-center bg-slate-50 border border-slate-200 rounded-xl p-2 shrink-0">
                    <img src="{{ asset('storage/'.$setting->logo) }}" class="max-h-full max-w-full object-contain">
                </div>
            @else
                <div class="h-20 w-20 flex items-center justify-center bg-primary-50 text-primary-600 border border-primary-200 rounded-xl shrink-0">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
            @endif
            <div>
                <h3 class="font-bold text-slate-800 text-base">Logo Resmi Perusahaan</h3>
                <p class="text-xs text-slate-400 mt-0.5">Dipakai di navbar atas, footer, dan sidebar admin. Disarankan format PNG transparan.</p>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pilih File Logo Baru</label>
            <input type="file" name="logo" accept="image/*" class="w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-50 file:text-primary-600 hover:file:bg-primary-100 transition" required>
        </div>

        <button class="btn-primary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            Simpan Logo
        </button>
    </form>
</div>
@endsection
