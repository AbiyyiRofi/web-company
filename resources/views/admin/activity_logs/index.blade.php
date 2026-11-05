@extends('layouts.admin')

@section('title', 'Log Activity (Audit Trail)')

@section('content')
<div x-data="logViewer()" x-init="initPolling()" class="space-y-6">

    {{-- ━━━ HEADER SECTION ━━━ --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    Live Monitoring Real-Time
                </span>
            </div>
            <h2 class="text-xl font-bold text-slate-800 mt-1">Log Aktivitas Administrator</h2>
            <p class="text-xs text-slate-500 mt-0.5">Pantau seluruh kegiatan login, perubahan konten, dan penghapusan data secara terpusat.</p>
        </div>

        <div class="flex items-center gap-3">
            <button @click="fetchNewLogs(true)" :disabled="loading" class="btn-secondary text-xs">
                <svg class="w-4 h-4 text-slate-500" :class="{'animate-spin': loading}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                <span>Refresh Data</span>
            </button>
        </div>
    </div>

    {{-- ━━━ FILTER BAR ━━━ --}}
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Cari Keyword / IP</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari deskripsi, IP, nama..." class="admin-input text-xs">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Modul / Fitur</label>
                <select name="module" class="admin-input text-xs">
                    <option value="">Semua Modul</option>
                    @foreach($modules as $mod)
                        <option value="{{ $mod }}" {{ request('module') == $mod ? 'selected' : '' }}>{{ $mod }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Jenis Aksi</label>
                <select name="action" class="admin-input text-xs">
                    <option value="">Semua Aksi</option>
                    <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login</option>
                    <option value="logout" {{ request('action') == 'logout' ? 'selected' : '' }}>Logout</option>
                    <option value="create" {{ request('action') == 'create' ? 'selected' : '' }}>Tambah (Create)</option>
                    <option value="update" {{ request('action') == 'update' ? 'selected' : '' }}>Edit (Update)</option>
                    <option value="delete" {{ request('action') == 'delete' ? 'selected' : '' }}>Hapus (Delete)</option>
                    <option value="status_toggle" {{ request('action') == 'status_toggle' ? 'selected' : '' }}>Ubah Status</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Pengguna Admin</label>
                <select name="user_id" class="admin-input text-xs">
                    <option value="">Semua Admin</option>
                    @foreach($users as $usr)
                        <option value="{{ $usr->id }}" {{ request('user_id') == $usr->id ? 'selected' : '' }}>{{ $usr->name }} ({{ ucfirst($usr->role) }})</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-2 sm:col-span-2 lg:col-span-1">
                <button type="submit" class="btn-primary flex-1 justify-center text-xs">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    Filter
                </button>
                @if(request()->anyFilled(['search', 'module', 'action', 'user_id', 'date_from', 'date_to']))
                    <a href="{{ route('admin.activity-logs.index') }}" class="btn-secondary text-xs px-3" title="Reset Filter">Reset</a>
                @endif
            </div>
        </form>
    </div>

    {{-- ━━━ LOG TABLE ━━━ --}}
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden">
        <div class="table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th class="w-12 text-center">#</th>
                        <th>Waktu</th>
                        <th>Pengguna / Admin</th>
                        <th>Aksi & Modul</th>
                        <th>Deskripsi Aktivitas</th>
                        <th>IP Address</th>
                        <th class="text-right">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $index => $log)
                        @php
                            $actionColors = [
                                'create' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'update' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'delete' => 'bg-red-50 text-red-700 border-red-200',
                                'login' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'logout' => 'bg-slate-100 text-slate-700 border-slate-200',
                                'status_toggle' => 'bg-purple-50 text-purple-700 border-purple-200',
                            ];
                            $badgeStyle = $actionColors[strtolower($log->action)] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="text-center font-mono text-xs text-slate-400">
                                {{ $logs->firstItem() + $index }}
                            </td>
                            <td class="whitespace-nowrap">
                                <div class="text-xs font-semibold text-slate-800">{{ $log->created_at->translatedFormat('d M Y H:i:s') }}</div>
                                <div class="text-[10px] text-slate-400">{{ $log->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-slate-100 font-bold text-slate-600 flex items-center justify-center text-xs shrink-0">
                                        {{ strtoupper(substr($log->user_name ?? 'S', 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs font-medium text-slate-800 truncate">{{ $log->user_name ?? 'System' }}</div>
                                        <div class="text-[10px] text-slate-400 truncate">{{ $log->user_email ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap">
                                <div class="flex items-center gap-1.5">
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded-md border uppercase {{ $badgeStyle }}">
                                        {{ $log->action }}
                                    </span>
                                    <span class="text-xs font-medium text-slate-600 bg-slate-100 px-2 py-0.5 rounded-md">
                                        {{ $log->module }}
                                    </span>
                                </div>
                            </td>
                            <td class="max-w-md">
                                <p class="text-xs text-slate-700 font-medium line-clamp-2 leading-relaxed">{{ $log->description }}</p>
                            </td>
                            <td class="whitespace-nowrap font-mono text-[11px] text-slate-500">
                                {{ $log->ip_address ?? '-' }}
                            </td>
                            <td class="text-right whitespace-nowrap">
                                @if($log->properties || $log->user_agent)
                                    <button @click='openDetail(@json($log))' class="text-xs font-semibold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-2.5 py-1 rounded-lg transition">
                                        Lihat JSON
                                    </button>
                                @else
                                    <span class="text-xs text-slate-300">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-3 text-slate-400">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-700">Belum Ada Log Aktivitas</p>
                                <p class="text-xs text-slate-400 mt-1">Seluruh log tindakan admin di sistem akan secara otomatis muncul di sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    {{-- ━━━ JSON / METADATA MODAL ━━━ --}}
    <div x-show="modalOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         style="display: none;">
        
        <div @click.away="modalOpen = false" class="bg-white rounded-2xl max-w-xl w-full shadow-2xl border border-slate-200 overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                <div>
                    <h3 class="font-bold text-slate-800 text-sm">Rincian Metadata Log</h3>
                    <p class="text-[11px] text-slate-500" x-text="activeLog?.created_at"></p>
                </div>
                <button @click="modalOpen = false" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-200 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="p-4 sm:p-5 space-y-4 max-h-[70vh] overflow-y-auto">
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Deskripsi</span>
                    <p class="text-xs font-semibold text-slate-800" x-text="activeLog?.description"></p>
                </div>

                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">User Agent (Browser & Device)</span>
                    <p class="text-xs font-mono bg-slate-100 p-2.5 rounded-lg text-slate-700 break-all" x-text="activeLog?.user_agent || '-'"></p>
                </div>

                <template x-if="activeLog?.properties">
                    <div>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Properties (JSON Payload)</span>
                        <pre class="text-xs font-mono bg-slate-900 text-emerald-400 p-3 rounded-xl overflow-x-auto" x-text="JSON.stringify(activeLog?.properties, null, 2)"></pre>
                    </div>
                </template>
            </div>

            <div class="p-4 bg-slate-50 border-t border-slate-200 text-right">
                <button @click="modalOpen = false" class="btn-secondary text-xs">Tutup</button>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
function logViewer() {
    return {
        loading: false,
        modalOpen: false,
        activeLog: null,
        lastLogId: {{ $logs->first()?->id ?? 0 }},
        initPolling() {
            // Auto refresh log list every 6 seconds
            setInterval(() => {
                this.fetchNewLogs(false);
            }, 6000);
        },
        async fetchNewLogs(manual = false) {
            if (this.loading) return;
            this.loading = true;
            try {
                const res = await fetch(`{{ route('admin.activity-logs.fetch') }}?last_id=${this.lastLogId}`);
                const data = await res.json();
                if (data.new_count > 0 && manual) {
                    window.location.reload();
                }
            } catch (err) {
                console.error('Polling error:', err);
            } finally {
                this.loading = false;
            }
        },
        openDetail(log) {
            this.activeLog = log;
            this.modalOpen = true;
        }
    }
}
</script>
@endpush
@endsection
