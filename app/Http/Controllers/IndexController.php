<?php

namespace App\Http\Controllers;

use App\Models\IndexData;
use App\Models\Post;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->take(3)->get();
        $categories = Post::select('category')->distinct()->pluck('category');
        $countTransactions = Transaction::whereHas('booking', function ($query) {
            $query->where('booking_status', '>=', 2);
        })->count();
        $countUsers = User::count();
        return view('user.index', compact('posts', 'categories', 'countUsers', 'countTransactions'));
    }

    public function indexData()
    {
        $data = IndexData::first();
        return view('admin.data-setting.index', compact('data'));
    }

    public function updateIndexData(Request $request, $id)
    {
        $request->validate([
            'address' => 'required',
            'phone' => 'required|numeric|digits_between:10,13',
            'email' => 'required|email',
        ], [
            'address.required' => 'Alamat harus diisi',
            'phone.required' => 'Nomor telepon harus diisi',
            'phone.numeric' => 'Nomor telepon harus berupa angka',
            'phone.digits_between' => 'Nomor telepon harus 10-13 angka',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email harus berupa email',
        ]);

        IndexData::find($id)->update($request->all());
        
        return redirect()->route('admin.indexData')->with('success', 'Data index berhasil diperbarui');
    }
}
