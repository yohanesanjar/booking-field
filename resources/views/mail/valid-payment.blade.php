<p>Kepada {{ $booking->customer_name }}, </p>
<p>Pemesanan lapangan di GOR Jaya Abadi dengan Transaction ID {{ $booking->transactions->first()->id }} berhasil diproses.</p>
<a href="{{ route('user.transactionHistoryDetail', $booking->transactions->first()->id) }}">Klik di sini untuk melihat detail</a>