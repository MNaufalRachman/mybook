<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Tampilkan daftar user (admin only)
     */
    public function index()
    {
        $users = User::paginate(10); // Pagination 10 per halaman
        return view('profile.manajemen', compact('users'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
        'role'     => 'required|in:admin,user',
    ]);

    User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => bcrypt($request->password),
        'role'     => $request->role,
    ]);

    return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
}

    /**
     * Halaman form edit user
     */
    public function edit($id)
{
    $editing = User::findOrFail($id);
    $users = User::paginate(10); // Tambahkan ini
    return view('profile.manajemen', compact('editing', 'users'));
}

    /**
     * Proses update data user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|string|min:6',
            'role'  => 'required|in:admin,user',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role'  => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Hapus user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Jangan izinkan admin menghapus dirinya sendiri
        if (auth()->id() == $user->id) { // Undefined method 'id'
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
