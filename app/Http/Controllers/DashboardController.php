<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $currentYear = date('Y');
        $currentMonth = date('m');

        $transactions = Transaction::whereYear('created_at', $currentYear)
            ->whereHas('booking', function ($query) {
                $query->where('booking_status', '>=', 2);
            })
            ->get();

        $totalCurrentYear = $transactions->sum(function ($transaction) {
            return $transaction->down_payment + $transaction->remaining_payment;
        });

        $transactions = Transaction::whereMonth('created_at', $currentMonth)
            ->whereHas('booking', function ($query) {
                $query->where('booking_status', '>=', 2);
            })
            ->get();

        $totalCurrentMonth = $transactions->sum(function ($transaction) {
            return $transaction->down_payment + $transaction->remaining_payment;
        });

        $earningsPerMonth = [];
        for ($month = 1; $month <= 12; $month++) {
            $transactions = Transaction::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->whereHas('booking', function ($query) {
                    $query->where('booking_status', '>=', 2);
                })
                ->get();

            $currentMonthSum = $transactions->sum(function ($transaction) {
                return $transaction->down_payment + $transaction->remaining_payment;
            });

            $earningsPerMonth[] = $currentMonthSum;
        }

        // Mengambil total transaksi yang sukses berdasarkan field_type menggunakan Eloquent
        $transactionSuccessByFieldType = Transaction::with(['booking.fieldData'])
            ->whereHas('booking', function ($query) {
                $query->where('booking_status', '>=', 2);
            })
            ->get()
            ->groupBy(function ($transaction) {
                return $transaction->booking->fieldData->field_type;
            })
            ->map(function ($transactions) {
                return $transactions->count();
            });

        // Mengubah data yang dihasilkan ke format yang cocok untuk digunakan dalam grafik
        $labels = $transactionSuccessByFieldType->keys();
        $data = $transactionSuccessByFieldType->values();

        return view('admin.dashboard', compact('totalCurrentYear', 'totalCurrentMonth', 'earningsPerMonth', 'labels', 'data'));
    }
}
