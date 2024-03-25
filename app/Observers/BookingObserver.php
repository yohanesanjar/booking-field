<?php

namespace App\Observers;

use App\Models\Booking;
use Carbon\Carbon;

class BookingObserver
{
    public function creating(Booking $booking)
    {
        // Mendapatkan tanggal dan bulan saat ini
        $yearMonth = Carbon::now()->format('ym');

        // Mencari id terakhir untuk bulan ini
        $lastBooking = Booking::where('id', 'like', 'GJA' . $yearMonth . '%')->latest()->first();
        if ($lastBooking) {
            // Jika ada booking sebelumnya pada bulan ini, tambahkan 1 pada increment
            $increment = intval(substr($lastBooking->id, -3)) + 1;
        } else {
            // Jika tidak ada booking pada bulan ini, mulai dari 001
            $increment = 1;
        }

        // Format ulang increment dengan padding nol
        $increment = str_pad($increment, 3, '0', STR_PAD_LEFT);

        // Set nilai ID berdasarkan pola tahun, bulan, dan increment
        $booking->id = 'GJA' . $yearMonth . $increment;
    }
}
