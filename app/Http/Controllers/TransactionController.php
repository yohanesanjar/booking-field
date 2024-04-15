<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function transactionHistory()
    {
        $transactions = Transaction::with('booking.fieldData')->where('user_id', auth()->user()->id)->get();
        return view('user.transaction.transaction-history', compact('transactions'));
    }

    public function transactionHistoryShow($id)
    {
        $transaction = Transaction::with('paymentMethodDP','paymentMethodRemaining', 'booking.fieldData', 'booking.bookingDetails.fieldSchedule')->find($id);
        // Periksa apakah transaksi ditemukan
        if (!$transaction) {
            return abort(404); // Atau bisa juga return redirect()->route('route_name')->with('error', 'Transaksi tidak ditemukan');
        }

        if($transaction->user_id != auth()->user()->id){
            return abort(403);
        }
        
        return view('user.transaction.history-detail', compact('transaction'));
    }
}
