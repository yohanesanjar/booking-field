@extends('admin.layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Booking</h1>
    </div>
    @if (session('success'))
        <div class="alert alert-success d-flex justify-content-between align-items-center">
            {{ session('success') }}
            <button type="button" class="btn-close flex-end" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="py-3">
        <a href="{{ route('admin.chooseField') }}" class="btn btn-primary">Tambah</a>
    </div>
    <!-- Content Row -->
    <div class="row">

        <!-- Area Chart -->
        <div class="col">
            <table class="table table-hover text-nowrap" id="myTable" style="width: 100%">
                <thead>
                    <tr>
                        <th class="text-center">Id Booking</th>
                        <th class="text-center">Nama Pemesan</th>
                        <th class="text-center">Tanggal Booking</th>
                        <th class="text-center">Nama Lapangan</th>
                        <th class="text-center">Jenis Lapangan</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td class="text-center">{{ $booking->id }}</td>
                            <td class="text-center">{{ $booking->customer_name }}</td>
                            <td class="text-center">{{ $booking->created_at }}</td>
                            <td class="text-center">{{ $booking->fieldData->name }}</td>
                            <td class="text-center">{{ $booking->fieldData->field_type }}</td>
                            <td class="text-center">Rp {{ number_format($booking->total_subtotal, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @if ($booking->booking_status == 0)
                                    <span class="badge text-bg-danger text-white">Tidak valid</span>
                                @elseif($booking->booking_status == 1)
                                    <span class="badge text-bg-warning text-white">Butuh konfirmasi</span>
                                @elseif($booking->booking_status == 2)
                                    <span class="badge text-bg-primary text-white">Sudah bayar DP</span>
                                @elseif($booking->booking_status == 3)
                                    <span class="badge text-bg-secondary text-white">Dibatalkan</span>
                                @elseif($booking->booking_status == 4)
                                    <span class="badge text-bg-success text-white">Lunas</span>
                                @elseif($booking->booking_status == -1)
                                    <span style="background-color:saddlebrown" class="badge text-white">Tunggu</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $booking->id }} ">Lihat</a>
                                    {{-- Modal --}}
                                    <div class="modal fade" id="detailModal{{ $booking->id }}" tabindex="-1"
                                        aria-labelledby="detailModal{{ $booking->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="detailModal{{ $booking->id }}">
                                                        {{ $booking->id }} |
                                                        {{ explode(' ', $booking->customer_name)[0] }}
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-2">
                                                        <div class="col text-start">
                                                            <label for="message-text" class="col-label">Tanggal
                                                                Booking:</label>
                                                            <p>{{ $booking->created_at }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col text-start">
                                                            <label for="message-text" class="col-label">Nama
                                                                Lapangan:</label>
                                                            <p>{{ $booking->fieldData->name }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col text-start">
                                                            <label for="message-text" class="col-label">Jenis
                                                                Lapangan:</label>
                                                            <p>{{ $booking->fieldData->field_type }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col text-start">
                                                            <label for="message-text" class="col-label">Detail
                                                                Booking:</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center" scope="col">Jadwal</th>
                                                                        <th class="text-center" scope="col">Jam Bermain
                                                                        </th>
                                                                        <th class="text-center" scope="col">Sub Total
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $lastSchedule = null;
                                                                        $totalSubtotal = 0;
                                                                    @endphp
                                                                    @foreach ($booking->bookingDetails as $data)
                                                                        <tr>
                                                                            <td>
                                                                                @if ($lastSchedule !== $data->schedule_play)
                                                                                    {{ $data->schedule_play }}
                                                                                    @php
                                                                                        $lastSchedule =
                                                                                            $data->schedule_play;
                                                                                    @endphp
                                                                                @endif
                                                                            </td>
                                                                            <td>{{ $data->fieldSchedule->start_time }} -
                                                                                {{ $data->fieldSchedule->end_time }}</td>
                                                                            <td>Rp
                                                                                {{ number_format($data->sub_total, 0, ',', '.') }}
                                                                            </td>
                                                                        </tr>
                                                                        @php
                                                                            $totalSubtotal += $data->sub_total;
                                                                        @endphp
                                                                    @endforeach
                                                                    <tr>
                                                                        <td></td>
                                                                        <td>Total</td>
                                                                        <td>Rp
                                                                            {{ number_format($totalSubtotal, 0, ',', '.') }}
                                                                        </td>
                                                                    </tr>
                                                                    @if ($booking->is_member == 1)
                                                                        <tr>
                                                                            <td></td>
                                                                            <td class="text-center">Diskon Member</td>
                                                                            <td>Rp.
                                                                                {{ number_format($booking->discount, 0, ',', '.') }}
                                                                            </td>
                                                                        </tr>
                                                                    @else
                                                                        <tr>
                                                                            <td></td>
                                                                            <td class="text-center">Diskon</td>
                                                                            <td>Rp.
                                                                                {{ number_format($booking->discount, 0, ',', '.') }}
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                    <tr>
                                                                        <td></td>
                                                                        <td><strong>Total Bayar</strong></td>
                                                                        <td><strong>Rp
                                                                                {{ number_format($booking->total_subtotal, 0, ',', '.') }}</strong>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col text-start">
                                                            <label for="message-text" class="col-label">DP:</label>
                                                            <p>Rp.
                                                                {{ number_format($booking->transactions->first()->down_payment, 0, ',', '.') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col text-start">
                                                            <label for="message-text" class="col-label">Metode
                                                                Pembayaran:</label>
                                                            <p>{{ $booking->transactions->first()->paymentMethodDP->name }}
                                                            </p>
                                                        </div>
                                                        @if ($booking->transactions->first()->paymentMethodDP->id != 1)
                                                            <div class="col text-start">
                                                                <label for="payment_proof" class="col-label">Bukti
                                                                    Pembayaran<span class="text-danger">
                                                                        *</span></label>
                                                                <div>
                                                                    <img class="pb-3"
                                                                        src="{{ asset('storage/' . $booking->transactions->first()->payment_proof_dp) }}"
                                                                        id="payment-proof"style="width: 100px;">
                                                                </div>
                                                            </div>
                                                            <div class="col text-start">
                                                                <label for="message-text" class="col-label">Nama
                                                                    Akun:</label>
                                                                <p>{{ $booking->transactions->first()->account_name_dp }}
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($booking->booking_status == 1)
                                        <form action="{{ route('admin.confirmPaymentDP', $booking->id) }}"
                                            method="POST">
                                            @method('PUT')
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">Konfirmasi DP</button>
                                        </form>
                                        <form action="{{ route('admin.invalidatePaymentDP', $booking->id) }}"
                                            method="POST">
                                            @method('PUT')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Tidak Valid</i></button>
                                        </form>
                                    @elseif ($booking->booking_status == 2)
                                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#remaining_payment{{ $booking->id }}">Konfirmasi
                                            Pelunasan</a>
                                        <div class="modal fade" id="remaining_payment{{ $booking->id }}" tabindex="-1"
                                            aria-labelledby="remaining_payment{{ $booking->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5"
                                                            id="remaining_payment{{ $booking->id }}">Konfirmasi
                                                            Pelunasan</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form
                                                        action="{{ route('admin.confirmPaymentRemaining', $booking->transactions->first()->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3 text-start">
                                                                <label for="remaining_payment"
                                                                    class="form-control-label">Sisa
                                                                    Pembayaran</label>
                                                                <input type="number" id="remaining_payment"
                                                                    name="remaining_payment" class="form-control"
                                                                    value="{{ $booking->total_subtotal - $booking->transactions->first()->down_payment }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="mb-3 text-start">
                                                                <label for="payment_method" class="col-form-label">Jenis
                                                                    Pembayaran <span class="text-danger"> *</span></label>
                                                                <select
                                                                    class="form-select @error('payment_method') is-invalid @enderror"
                                                                    aria-label="payment_method" id="payment_method"
                                                                    name="payment_method"
                                                                    onchange="showHidePaymentFields()">
                                                                    <option selected disabled>- Pilih jenis pembayaran -
                                                                    </option>
                                                                    @foreach ($paymentMethods as $pm)
                                                                        <option value="{{ $pm->id }}"
                                                                            {{ old('payment_method') == $pm->name ? 'selected' : '' }}>
                                                                            {{ $pm->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div id="paymentProof" class="mb-3 text-start"
                                                                style="display: none;">
                                                                <label for="payment_proof"
                                                                    class="form-control-label">Bukti
                                                                    Pembayaran<span class="text-danger">
                                                                        *</span></label>
                                                                <div>
                                                                    <img class="pb-3"
                                                                        id="payment-proof-preview"style="width: 100px;">
                                                                </div>

                                                                <input class="form-control" type="file"
                                                                    name="payment_proof" id="payment_proof"
                                                                    onchange="previewPaymentProof(this)">
                                                                @error('payment_proof')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div id="accountName" class="mb-3 text-start"
                                                                style="display: none;">
                                                                <label for="account_name"
                                                                    class="form-control-label">Masukkan
                                                                    Nama Rekening</label>
                                                                <input type="text" id="account_name"
                                                                    name="account_name" class="form-control">
                                                                <!-- Pesan kesalahan jika terjadi kesalahan validasi -->
                                                                @error('account_name')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="{{ route('admin.canceledBooking', $booking->id) }}" method="POST">
                                            @method('PUT')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-secondary">Batal</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
    @section('script')
        <script>
            function showHidePaymentFields() {
                var paymentMethod = document.getElementById('payment_method').value;
                if (paymentMethod != 1) {
                    document.getElementById('paymentProof').style.display = 'block';
                    document.getElementById('accountName').style.display = 'block';
                } else {
                    document.getElementById('paymentProof').style.display = 'none';
                    document.getElementById('accountName').style.display = 'none';
                }
            }
        </script>
    @endsection
