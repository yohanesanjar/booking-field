<p>Kepada {{ $booking->customer_name }}, </p>
<p>Pemesanan lapangan di GOR Jaya Abadi dengan Transaction ID {{ $booking->transactions->first()->id }} tidak dapat diproses, karena pembayaran
    yang dilakukan tidak sesuai ketentuan.</p>
<p>Silahkan melakukan pemesanan kembali.</p>