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
        return view('admin.owner.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.owner.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
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
            'role.required' => 'Role harus dipilih',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role,
        ]);

        if ($user) {
            session()->flash('success', 'Data user berhasil ditambahkan');
            return redirect()->route('owner.userIndex');
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();

        if (!$user) {
            return view('admin.owner.404');
        }
        
        return view('admin.owner.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'role' => 'required',
        ], [
            'name.required' => 'Nama lengkap harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah terdaftar',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email harus berupa email',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 6 karakter',
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
            return redirect()->route('owner.userIndex');
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            session()->flash('success', 'Data user berhasil dihapus');
            return redirect()->route('owner.userIndex');
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }
    }
}
