@extends('layouts.admin')

@section('title', 'Edit Admin — ' . $user->name)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Edit Akun Admin</h2>
            <p class="text-xs text-slate-500 mt-0.5">Perbarui data profil, email, role, atau reset password admin.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn-secondary text-xs">
            &larr; Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="admin-input text-xs">
                @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="admin-input text-xs">
                @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Role --}}
            <div>
                <label for="role" class="block text-xs font-semibold text-slate-700 mb-1">Role Hak Akses <span class="text-red-500">*</span></label>
                <select name="role" id="role" required class="admin-input text-xs">
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin / Humas (Pengelola Konten)</option>
                    <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>Super Admin (Konten + Log Activity + Kelola Admin)</option>
                </select>
                @error('role')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="pt-3 border-t border-slate-100 space-y-4">
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 text-xs text-amber-800">
                    <strong>Ganti / Reset Password (Opsional):</strong> Kosongkan input password di bawah ini jika tidak ingin mengubah password user ini.
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Password Baru (Opsional)</label>
                        <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" class="admin-input text-xs">
                        @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Password Confirmation --}}
                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password baru" class="admin-input text-xs">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="btn-secondary text-xs">Batal</a>
                <button type="submit" class="btn-primary text-xs">Perbarui Akun Admin</button>
            </div>
        </form>
    </div>

</div>
@endsection
