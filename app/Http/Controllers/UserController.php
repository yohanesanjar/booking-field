<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'required|numeric|digits_between:10,13',
            'role' => 'required',
        ], [
            'name.required' => 'Nama lengkap harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah terdaftar',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email harus berupa email',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'phone.required' => 'Nomor telepon harus diisi',
            'phone.numeric' => 'Nomor telepon harus berupa angka',
            'phone.digits_between' => 'Nomor telepon harus 10-13 angka',
            'role.required' => 'Role harus dipilih',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'role_id' => $request->role,
        ]);

        if ($user) {
            session()->flash('success', 'Data user berhasil ditambahkan');
            return redirect()->route('admin.userIndex');
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();

        if (!$user) {
            return view('admin.404');
        }

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'phone' => 'required|numeric|digits_between:10,13',
            'role' => 'required',
        ], [
            'name.required' => 'Nama lengkap harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah terdaftar',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email harus berupa email',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 6 karakter',
            'phone.required' => 'Nomor telepon harus diisi',
            'phone.numeric' => 'Nomor telepon harus berupa angka',
            'phone.digits_between' => 'Nomor telepon harus 10-13 angka',
            'role.required' => 'Role harus dipilih',
        ]);

        $user = User::find($id);

        if ($user) {
            $user->fill([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'role_id' => $request->role,
            ]);

            if (!empty($request->password)) {
                $user->password = bcrypt($request->password);
            }

            $user->save();

            session()->flash('success', 'Data user berhasil diubah');
            return redirect()->route('admin.userIndex');
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $usedInTransaction = $user->transactions()->exists();

        if ($user) {
            // Memeriksa apakah ID pengguna adalah 1 (ID admin)
            if ($user->id === 1) {
                // Jika ID pengguna adalah 1, kembalikan pesan kesalahan
                return redirect()->back()->with('error', 'Pengguna pertama tidak bisa dihapus.');
            } elseif ($usedInTransaction) {
                session()->flash('error', 'Pengguna tidak bisa dihapus karena sudah pernah melakukan transaksi.');
                return back();
            } else {
                // Jika bukan admin, hapus pengguna dan tampilkan pesan sukses
                $user->delete();
                session()->flash('success', 'Data user berhasil dihapus');
                return redirect()->route('admin.userIndex');
            }
        } else {
            // Jika pengguna tidak ditemukan, kembalikan pesan kesalahan
            return redirect()->back()->with('error', 'User not found.');
        }
    }
}
