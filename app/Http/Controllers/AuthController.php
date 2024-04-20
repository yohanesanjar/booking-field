<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Mail\ResetPassword;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->role->name == 'admin') {
                return redirect()->route('admin.dashboard');
            } else if (Auth::user()->role->name == 'user') {
                return redirect()->route('user.index');
            }
        }

        $posts = Post::latest()->take(3)->get();
        $categories = Post::select('category')->distinct()->pluck('category');
        $countTransactions = Transaction::whereHas('booking', function ($query) {
            $query->where('booking_status', '>=', 2);
        })->count();
        $countUsers = User::count();
        return view('user.index', compact('posts', 'categories', 'countUsers', 'countTransactions'));
    }

    public function registerView()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'phone' => 'required|numeric|digits_between:10,13',
        ], [
            'name.required' => 'Nama lengkap harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah terdaftar',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email harus berupa email',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'phone.required' => 'Nomor telepon harus diisi',
            'phone.numeric' => 'Nomor telepon harus berupa angka',
            'phone.digits_between' => 'Nomor telepon harus 10-13 angka',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role_id' => 2,
        ]);

        if ($user) {
            session()->flash('success', 'Akun berhasil dibuat');
            return redirect()->route('login');
        } else {
            session()->flash('error', 'Akun gagal ditambahkan');
            return back();
        }
    }

    public function loginView()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        if (
            Auth::attempt(['email' => $credentials['login'], 'password' => $credentials['password']]) ||
            Auth::attempt(['username' => $credentials['login'], 'password' => $credentials['password']])
        ) {
            if (Auth::user()->role->name == 'admin') {
                return redirect()->route('admin.dashboard');
            } else if (Auth::user()->role->name == 'user') {
                return redirect()->route('user.index');
            }
        }

        session()->flash('error', 'Username atau Password salah!');
        return back();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index');
    }

    public function forgotPasswordView()
    {
        if (Auth::check()) {
            return redirect()->route('index');
        }

        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email harus berupa email',
            'email.exists' => 'Email tidak terdaftar',
        ]);

        $token = \Str::random(60);

        PasswordResetToken::updateOrCreate(
            [
                'email' => $request->email
            ],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]
        );

        Mail::to($request->email)->send(new ResetPassword($token));

        $data = [
            'email' => $request->email,
        ];

        return redirect()->route('forgotPassword')->with('success', 'Link telah dikirim ke email anda');
    }

    public function newPasswordView($token)
    {
        $getToken = PasswordResetToken::where('token', $token)->first();

        if (!$getToken) {
            return redirect()->route('login')->with('error', 'Token tidak valid');
        }

        return view('auth.new-password', compact('token'));
    }

    public function newPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
        ], [
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        $token = PasswordResetToken::where('token', $request->token)->first();
        $user = User::where('email', $token->email)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Email tidak terdaftar');
        }

        $user->update([
            'password' => bcrypt($request->password)
        ]);

        $token->delete();

        return redirect()->route('login')->with('success', 'Password berhasil diubah');
    }

    // Profile

    public function profile()
    {
        $user = auth()->user();
        $profile = Auth::user();

        if ($user->role_id == 1) {
            return view('admin.profile.index', compact('profile'));
        } elseif ($user->role_id == 2) {
            return view('user.profile.index', compact('profile'));
        } else {
            return abort(403);
        }
    }

    public function editProfile($id)
    {
        $user = auth()->user();
        $profile = User::find($id);
        if (Auth::user()->id != $id) {
            return abort(403);
        }

        if ($user->role_id == 1) {
            return view('admin.profile.edit', compact('profile'));
        } elseif ($user->role_id == 2) {
            return view('user.profile.edit', compact('profile'));
        } else {
            return abort(403);
        }
    }

    public function updateProfile(Request $request, $id)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|numeric|digits_between:10,13',
            'password' => 'nullable|min:6',
        ], [
            'name.required' => 'Nama lengkap harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah terdaftar',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email harus berupa email',
            'email.unique' => 'Email sudah terdaftar',
            'phone.required' => 'Nomor telepon harus diisi',
            'phone.numeric' => 'Nomor telepon harus berupa angka',
            'phone.digits_between' => 'Nomor telepon harus 10-13 angka',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        $profile = User::find($id);

        if (Auth::user()->id != $id) {
            return abort(403);
        }

        $profile->fill([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        if (!empty($request->password)) {
            $profile->password = bcrypt($request->password);
        }

        if ($request->hasFile('avatar')) {
            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }

            $profile->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $profile->save();

        if ($user->role_id == 1) {
            return redirect()->route('admin.profile')->with('success', 'Profile berhasil diperbarui');
        } elseif ($user->role_id == 2) {
            return redirect()->route('user.profile')->with('success', 'Profile berhasil diperbarui');
        } else {
            return abort(403);
        }
    }
}
