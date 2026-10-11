<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan semua user
    public function index(Request $request)
    {
        $search = $request->search;

        $users = User::when($search, function ($query) use ($search) {

            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('departemen', 'like', "%{$search}%")
                ->orWhere('role', 'like', "%{$search}%");

        })
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function export()
    {
        return Excel::download(
            new UserExport,
            'data-user.xlsx'
        );
    }

    // Form tambah user
    public function create()
    {
        return view('admin.users.create');
    }

    // Simpan user
    public function store(Request $request)
        {
            $request->validate([
        'nama' => 'required',
        'username' => 'required|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'departemen' => 'required',
        'role' => 'required',
        'password' => 'required|min:6',
        ], [
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email tersebut sudah digunakan.',
        ]);

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'departemen' => $request->departemen,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    // Form edit
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'departemen' => 'required',
            'role' => 'required',
        ], [
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email tersebut sudah digunakan.',
        ]);

        $user = User::findOrFail($id);

        $data = [
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'departemen' => $request->departemen,
            'role' => $request->role,
        ];

        if ($request->password != null) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diupdate.');
    }

    // Riwayat peminjaman user
    public function history($id)
    {
        $user = User::findOrFail($id);

        $peminjaman = $user->peminjaman()
            ->with('detailPeminjaman.barang')
            ->latest()
            ->paginate(10);

        return view('admin.users.history', compact('user', 'peminjaman'));
    }

    // Hapus user
    public function destroy($id)
    {
        // Tidak boleh menghapus akun sendiri
        if ($id == session('user_id')) {
            return redirect()->route('users.index')
                ->with(
                    'error',
                    'Anda tidak dapat menghapus akun yang sedang digunakan.'
                );
        }

        User::findOrFail($id)->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}