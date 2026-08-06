@extends('layouts.app')
@section('title', 'Publikasi')

@section('content')
<section class="relative h-64 sm:h-72 bg-slate-900 overflow-hidden">
    <img src="{{ $header->header_image ? asset('storage/'.$header->header_image) : 'https://placehold.co/1600x600/1d4ed8/white?text=Publikasi' }}" class="w-full h-full object-cover brightness-[0.45] blur-[1px]">
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 w-full" data-reveal-group>
            @include('partials.breadcrumb', ['currentPage' => 'Publikasi'])
            <h1 class="text-3xl sm:text-4xl font-bold text-white reveal">Publikasi</h1>
            @if($header->header_caption)
                <p class="text-primary-100 mt-2 max-w-2xl reveal">{{ $header->header_caption }}</p>
            @endif
        </div>
    </div>
</section>

<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div>
        <div class="flex gap-2 mb-8 border-b reveal">
            <button onclick="showTab('dokumen')" id="tabBtn-dokumen" class="px-5 py-3 font-medium border-b-2 border-primary-600 text-primary-600 -mb-px transition">Dokumen Publik</button>
            <button onclick="showTab('profile')" id="tabBtn-profile" class="px-5 py-3 font-medium border-b-2 border-transparent text-slate-500 hover:text-primary-600 -mb-px transition">Company Profile</button>
        </div>

        <div id="tab-dokumen" class="grid sm:grid-cols-2 gap-4" data-reveal-group>
            @forelse($dokumenPublik as $doc)
                <a href="{{ route('publications.download', $doc) }}" class="flex items-center gap-4 bg-white border rounded-xl p-4 hover:shadow-lg hover:border-primary-300 transition-all reveal">
                    <span class="text-3xl">📄</span>
                    <div class="min-w-0">
                        <div class="font-medium text-sm truncate">{{ $doc->title }}</div>
                        <div class="text-xs text-slate-400">{{ strtoupper($doc->file_type) }} · Unduh</div>
                    </div>
                </a>
            @empty
                <p class="text-slate-400 col-span-2 reveal">Belum ada dokumen publik.</p>
            @endforelse
            <div class="col-span-2 reveal">{{ $dokumenPublik->links() }}</div>
        </div>

        <div id="tab-profile" class="hidden grid sm:grid-cols-2 gap-4" data-reveal-group>
            @forelse($companyProfiles as $doc)
                <a href="{{ route('publications.download', $doc) }}" class="flex items-center gap-4 bg-white border rounded-xl p-4 hover:shadow-lg hover:border-primary-300 transition-all reveal">
                    <span class="text-3xl">📄</span>
                    <div class="min-w-0">
                        <div class="font-medium text-sm truncate">{{ $doc->title }}</div>
                        <div class="text-xs text-slate-400">{{ strtoupper($doc->file_type) }} · Unduh</div>
                    </div>
                </a>
            @empty
                <p class="text-slate-400 col-span-2 reveal">Belum ada company profile.</p>
            @endforelse
        </div>
    </div>
</section>

@push('scripts')
<script>
    function showTab(name) {
        ['dokumen', 'profile'].forEach(t => {
            document.getElementById('tab-' + t).classList.toggle('hidden', t !== name);
            const btn = document.getElementById('tabBtn-' + t);
            btn.classList.toggle('border-primary-600', t === name);
            btn.classList.toggle('text-primary-600', t === name);
            btn.classList.toggle('border-transparent', t !== name);
            btn.classList.toggle('text-slate-500', t !== name);
        });
    }
</script>
@endpush
@endsection
