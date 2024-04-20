<?php

namespace App\Observers;

use App\Models\Transaction;
use Carbon\Carbon;


class TransactionObserver
{
    public function creating(Transaction $transaction)
    {
        // Mendapatkan tanggal saat ini dengan format YYYYMMDD
        $date = now()->format('Ym');

        // Mencari transaction terakhir pada tanggal ini
        $lastTransaction = Transaction::where('id', 'like', $date . '%')->latest()->first();

        // Jika ada transaction pada tanggal ini, tambahkan 1 pada increment
        if ($lastTransaction) {
            $lastId = $lastTransaction->id;
            $lastIncrement = intval(substr($lastId, -5));
            $increment = $lastIncrement + 1;
        } else {
            // Jika tidak ada transaction pada tanggal ini, mulai dari 1
            $increment = 1;
        }

        // Format ulang increment dengan padding nol hingga lima digit
        $increment = str_pad($increment, 5, '0', STR_PAD_LEFT);

        // Set nilai ID dengan pola tahun, bulan, tanggal, dan increment
        $transaction->id = $date . $increment;
    }
}
