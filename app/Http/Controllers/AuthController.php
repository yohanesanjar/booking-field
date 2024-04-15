<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->role->name == 'owner') {
                return redirect()->route('owner.dashboard');
            } else if (Auth::user()->role->name == 'advisor') {
                return redirect()->route('advisor.dashboard');
            } else if (Auth::user()->role->name == 'user') {
                return redirect()->route('user.index');
            }
        }

        return view('user.index');
    }

    public function loginView()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role->name == 'owner') {
                return redirect()->route('owner.dashboard');
            } else if (Auth::user()->role->name == 'advisor') {
                return redirect()->route('advisor.dashboard');
            } else if (Auth::user()->role->name == 'user') {
                return redirect()->route('user.index');
            }
        }

        return back()->withErrors('loginError', 'Username atau Password salah!');
    }

    public function logout(Request $request)
    {
        $user = auth()->user();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index');
    }
}
