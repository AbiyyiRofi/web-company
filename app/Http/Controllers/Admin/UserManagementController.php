<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $users = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', 'string', Rule::in(['admin', 'superadmin'])],
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => strtolower($validated['email']),
            'password'  => Hash::make($validated['password']),
            'role'      => $validated['role'],
            'is_active' => true,
        ]);

        ActivityLog::record(
            'create',
            'User',
            "Menambahkan Pengguna Admin Baru: \"{$user->name}\" ({$user->email}) dengan Role {$user->role}"
        );

        return redirect()->route('admin.users.index')->with('success', "Akun admin \"{$user->name}\" berhasil ditambahkan.");
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', 'string', Rule::in(['admin', 'superadmin'])],
        ]);

        $oldData = [
            'name'  => $user->name,
            'email' => $user->email,
            'role'  => $user->role,
        ];

        $user->name  = $validated['name'];
        $user->email = strtolower($validated['email']);
        $user->role  = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        ActivityLog::record(
            'update',
            'User',
            "Memperbarui Data Akun Admin: \"{$user->name}\" ({$user->email})",
            ['old' => $oldData, 'new' => ['name' => $user->name, 'email' => $user->email, 'role' => $user->role]]
        );

        return redirect()->route('admin.users.index')->with('success', "Data akun admin \"{$user->name}\" berhasil diperbarui.");
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri!');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $statusText = $user->is_active ? 'mengaktifkan' : 'menonaktifkan';

        ActivityLog::record(
            'status_toggle',
            'User',
            "Super Admin telah {$statusText} akun Admin: \"{$user->name}\" ({$user->email})"
        );

        return redirect()->back()->with('success', "Status akun \"{$user->name}\" berhasil diubah menjadi " . ($user->is_active ? 'Aktif' : 'Nonaktif') . ".");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login!');
        }

        $userName = $user->name;
        $userEmail = $user->email;

        ActivityLog::record(
            'delete',
            'User',
            "Menghapus Akun Admin secara permanen: \"{$userName}\" ({$userEmail})"
        );

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', "Akun admin \"{$userName}\" berhasil dihapus secara permanen.");
    }
}
