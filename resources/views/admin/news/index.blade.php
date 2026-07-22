@extends('layouts.admin')
@section('title', 'Perumdam TDA News')

@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('admin.news.create') }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm">+ Tambah Berita</a>
</div>

<div class="bg-white rounded-xl border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left text-slate-500">
            <tr><th class="p-4">Judul</th><th class="p-4">Foto</th><th class="p-4">Tanggal</th><th class="p-4">Aksi</th></tr>
        </thead>
        <tbody class="divide-y">
            @forelse ($news as $item)
                <tr>
                    <td class="p-4 font-medium">{{ $item->title }}</td>
                    <td class="p-4">{{ $item->images->count() }} foto</td>
                    <td class="p-4">{{ $item->created_at->format('d/m/Y') }}</td>
                    <td class="p-4 space-x-2">
                        <a href="{{ route('admin.news.edit', $item) }}" class="text-primary-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus berita ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="p-4 text-center text-slate-400">Belum ada berita.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $news->links() }}</div>
@endsection
