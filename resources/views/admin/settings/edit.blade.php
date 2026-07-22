@extends('layouts.admin')
@section('title', 'Pengaturan Logo')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border p-6 max-w-xl space-y-4">
    @csrf
    @if($setting->logo)
        <img src="{{ asset('storage/'.$setting->logo) }}" class="h-24 w-24 object-contain bg-slate-50 rounded-lg p-2">
    @else
        <div class="h-24 w-24 flex items-center justify-center bg-slate-50 rounded-lg text-4xl">💧</div>
    @endif
    <div>
        <label class="block text-sm font-medium mb-1">Logo Perusahaan</label>
        <input type="file" name="logo" accept="image/*" class="w-full text-sm" required>
        <p class="text-xs text-slate-400 mt-1">Dipakai di navbar atas, footer, dan sidebar admin. Disarankan pakai gambar PNG transparan.</p>
    </div>
    <button class="px-5 py-2 bg-primary-600 text-white rounded-lg text-sm">Simpan Logo</button>
</form>
@endsection
