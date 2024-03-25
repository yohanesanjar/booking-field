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
        <a href="{{ route('owner.chooseField') }}" class="btn btn-primary">Tambah</a>
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
                                @if ($booking->booking_status == 1)
                                    <span class="badge text-bg-success">Valid</span>
                                @else
                                    <span class="badge text-bg-danger">Invalid</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $booking->id }} "><i class="fa fa-eye"></i></a>

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
                                                    {{-- <div class="row mb-2">
                                                        <div class="col">
                                                            <img src="{{ asset('storage/' . $booking->thumbnail) }}"
                                                                style="width: 150px" alt="{{ $booking->thumbnail }}">
                                                        </div>
                                                    </div> --}}
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
                                                            <p>Rp. {{ number_format($booking->down_payment, 0, ',', '.') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col text-start">
                                                            <label for="message-text" class="col-label">Metode
                                                                Pembayaran:</label>
                                                            <p>{{ $booking->transactions->first()->paymentMethod->name }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    @if($booking->transactions->first()->paymentMethod->id != 1)
                                                    <div class="row mb-2">
                                                        <div class="col text-start">
                                                            <label for="payment_proof" class="col-label">Bukti
                                                                Pembayaran<span class="text-danger">
                                                                    *</span></label>
                                                            <div>
                                                                <img class="pb-3" src="{{ asset('storage/' . $booking->transactions->first()->payment_proof) }}" id="payment-proof"style="width: 100px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col text-start">
                                                            <label for="message-text" class="col-label">Nama Akun:</label>
                                                            <p>{{ $booking->transactions->first()->paymentMethod->account_name }}</p>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <a href="{{ route('owner.fieldEdit', $booking->id) }}"
                                                        class="btn btn-warning">Edit</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <form class="deleteForm" action="{{ route('owner.fieldDelete', $booking->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"
                                            type="button" class="btn btn-sm btn-danger deleteButton">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
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
            var deleteButtons = document.querySelectorAll('.deleteButton');

            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var form = this.closest('.deleteForm');

                    Swal.fire({
                        title: 'Hapus Request',
                        text: "Apakah Anda Yakin Untuk Menghapus?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endsection
