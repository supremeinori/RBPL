<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $sort = $request->input('sort', 'name');
        $direction = $request->input('direction', 'asc');

        $sortField = match ($sort) {
            'name' => 'name',
            'role' => 'role',
            default => 'name'
        };

        $users = $query->orderBy($sortField, $direction)->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,desainer,akuntan,superadmin',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        // Tidak boleh edit akun superadmin lain
        if ($user->role === 'superadmin' && $user->id !== auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Akun Super Admin tidak dapat diubah.');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Tidak boleh edit akun superadmin lain
        if ($user->role === 'superadmin' && $user->id !== auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Akun Super Admin tidak dapat diubah.');
        }

        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'role'     => 'required|in:admin,desainer,akuntan,superadmin',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ]);

        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Tidak boleh hapus akun superadmin sama sekali
        if ($user->role === 'superadmin') {
            return redirect()->route('admin.users.index')
                ->with('error', 'Akun Super Admin tidak dapat dihapus.');
        }

        // Tidak boleh hapus diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
