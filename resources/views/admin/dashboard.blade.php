@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="grid sm:grid-cols-3 lg:grid-cols-5 gap-6">
    <div class="bg-white rounded-xl p-6 border">
        <div class="text-3xl font-bold text-primary-700">{{ $stats['news'] }}</div>
        <div class="text-slate-500 text-sm mt-1">Perumdam TDA News</div>
        <a href="{{ route('admin.news.index') }}" class="text-primary-600 text-sm hover:underline mt-3 inline-block">Kelola →</a>
    </div>
    <div class="bg-white rounded-xl p-6 border">
        <div class="text-3xl font-bold text-primary-700">{{ $stats['announcements'] }}</div>
        <div class="text-slate-500 text-sm mt-1">Pengumuman</div>
        <a href="{{ route('admin.announcements.index') }}" class="text-primary-600 text-sm hover:underline mt-3 inline-block">Kelola →</a>
    </div>
    <div class="bg-white rounded-xl p-6 border">
        <div class="text-3xl font-bold text-primary-700">{{ $stats['galleries'] }}</div>
        <div class="text-slate-500 text-sm mt-1">Album Galeri</div>
        <a href="{{ route('admin.galleries.index') }}" class="text-primary-600 text-sm hover:underline mt-3 inline-block">Kelola →</a>
    </div>
    <div class="bg-white rounded-xl p-6 border">
        <div class="text-3xl font-bold text-primary-700">{{ $stats['documents'] }}</div>
        <div class="text-slate-500 text-sm mt-1">Dokumen Publikasi</div>
        <a href="{{ route('admin.publications.index') }}" class="text-primary-600 text-sm hover:underline mt-3 inline-block">Kelola →</a>
    </div>
    <div class="bg-white rounded-xl p-6 border">
        <div class="text-3xl font-bold text-primary-700">{{ $stats['branches'] }}</div>
        <div class="text-slate-500 text-sm mt-1">Cabang Layanan</div>
        <a href="{{ route('admin.branches.index') }}" class="text-primary-600 text-sm hover:underline mt-3 inline-block">Kelola →</a>
    </div>
</div>
@endsection
