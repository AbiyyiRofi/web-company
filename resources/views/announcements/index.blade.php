@extends('layouts.app')
@section('title', 'Pengumuman')

@section('content')
<section class="relative h-64 sm:h-72 bg-slate-900 overflow-hidden">
    <img src="{{ $header->header_image ? asset('storage/'.$header->header_image) : 'https://placehold.co/1600x600/1d4ed8/white?text=Pengumuman' }}" class="w-full h-full object-cover brightness-[0.45] blur-[1px]">
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 w-full">
            @include('partials.breadcrumb', ['currentPage' => 'Pengumuman'])
            <h1 class="text-3xl sm:text-4xl font-bold text-white">Pengumuman</h1>
            @if($header->header_caption)
                <p class="text-primary-100 mt-2 max-w-2xl">{{ $header->header_caption }}</p>
            @endif
        </div>
    </div>
</section>

<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-6">
    @forelse ($announcements as $ann)
        <div class="bg-white rounded-2xl border shadow-sm p-6 hover:shadow-lg transition-all">
            <h3 class="font-bold text-lg mb-1">{{ $ann->title }}</h3>
            <p class="text-xs text-slate-400 mb-4">{{ $ann->created_at->translatedFormat('d F Y') }}</p>

            @if($ann->description)
                <p class="text-slate-600 mb-4">{{ $ann->description }}</p>
            @endif

            @if($ann->document_path)
                <a href="{{ asset('storage/'.$ann->document_path) }}" target="_blank" class="flex items-center gap-3 bg-slate-50 hover:bg-primary-50 rounded-xl p-4 mb-4 transition">
                    <span class="text-2xl">📄</span>
                    <div>
                        <div class="font-medium text-sm">{{ $ann->title }}</div>
                        <div class="text-primary-600 text-xs font-semibold">Unduh</div>
                    </div>
                </a>
            @endif

            @if($ann->image)
                <img src="{{ asset('storage/'.$ann->image) }}" onclick="openLightbox(['{{ asset('storage/'.$ann->image) }}'], 0)"
                     class="w-full rounded-xl cursor-pointer hover:opacity-95 transition">
            @endif
        </div>
    @empty
        <p class="text-slate-500 text-center">Belum ada pengumuman.</p>
    @endforelse

    <div>{{ $announcements->links() }}</div>
</section>
@endsection
