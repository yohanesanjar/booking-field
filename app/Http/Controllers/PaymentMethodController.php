<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::whereNotIn('id', [1])->get();
        return view('admin.payment-method.index', compact('paymentMethods'));
    }

    public function create()
    {
        return view('admin.payment-method.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:payment_methods,name',
            'account_number' => 'required',
            'account_name' => 'required',
        ], [
            'name.required' => 'Nama bank harus diisi',
            'name.unique' => 'Nama bank sudah ada',
            'account_number.required' => 'Nomor rekening harus diisi',
            'account_name.required' => 'Nama rekening harus diisi',
        ]);

        PaymentMethod::create([
            'name' => $request->name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
        ]);

        session()->flash('success', 'Metode pembayaran baru ditambahkan');
        return redirect()->route('admin.paymentMethodIndex');
    }

    public function edit(string $id)
    {
        $paymentMethod = PaymentMethod::find($id);

        if (!$paymentMethod || $paymentMethod->id == 1) {
            return view('admin.404');
        }

        return view('admin.payment-method.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:payment_methods,name,' . $id,
            'account_number' => 'required',
            'account_name' => 'required',
        ], [
            'name.required' => 'Nama bank harus diisi',
            'name.unique' => 'Nama bank sudah ada',
            'account_number.required' => 'Nomor rekening harus diisi',
            'account_name.required' => 'Nama rekening harus diisi',
        ]);

        $paymentMethod = PaymentMethod::find($id);
        $paymentMethod->update([
            'name' => $request->name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
        ]);

        session()->flash('success', 'Metode pembayaran baru diperbarui');
        return redirect()->route('admin.paymentMethodIndex');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $paymentMethod = PaymentMethod::find($id);

        // Periksa apakah metode pembayaran sedang digunakan dalam transaksi DP
        $usedInDPTransactions = $paymentMethod->transactionDps()->exists();

        // Periksa apakah metode pembayaran sedang digunakan dalam transaksi sisa pembayaran
        $usedInRemainingTransactions = $paymentMethod->transactionsRemainings()->exists();

        // Jika metode pembayaran digunakan dalam transaksi, kembalikan ke halaman sebelumnya dengan pesan kesalahan
        if ($usedInDPTransactions || $usedInRemainingTransactions) {
            session()->flash('error', 'Metode pembayaran tidak bisa dihapus karena sudah digunakan dalam transaksi.');
            return back();
        }

        // Jika tidak digunakan dalam transaksi, hapus metode pembayaran
        $paymentMethod->delete();

        session()->flash('success', 'Metode pembayaran berhasil dihapus');
        return redirect()->route('admin.paymentMethodIndex');
    }
}
