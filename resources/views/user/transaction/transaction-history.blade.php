@extends('user.layouts.main')

@section('content')
    <!-- Header -->
    <header class="ex-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1">
                    <h1>Transaction History</h1>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header> <!-- end of ex-header -->
    <!-- end of header -->

    <!-- Content Row -->
    <div class="container py-3">
        <div class="row">

            <!-- Area Chart -->
            <div class="col">
                <table class="table table-hover text-nowrap" id="myTable" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="text-center">No. Invoice</th>
                            <th class="text-center">Nama Lapangan</th>
                            <th class="text-center">Jenis Lapangan</th>
                            <th class="text-center">Tanggal Pemesanan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Total Harga</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td class="text-center">{{ $transaction->id }}</td>
                                <td class="text-center">{{ $transaction->booking->fieldData->name }}</td>
                                <td class="text-center">{{ $transaction->booking->fieldData->field_type }}</td>
                                <td class="text-center">{{ $transaction->created_at->translatedFormat('l, d F Y') }}</td>
                                <td class="text-center">
                                    @if ($transaction->booking->booking_status == 0)
                                        <span class="badge text-bg-danger text-white">Invalid</span>
                                    @elseif($transaction->booking->booking_status == 1)
                                        <span class="badge text-bg-warning text-white">Pending</span>
                                    @elseif($transaction->booking->booking_status == 2)
                                        <span class="badge text-bg-primary text-white">Already paid dp</span>
                                    @elseif($transaction->booking->booking_status == 3)
                                        <span class="badge text-bg-secondary text-white">Canceled</span>
                                    @elseif($transaction->booking->booking_status == 4)
                                        <span class="badge text-bg-success text-white">Paid</span>
                                    @elseif($transaction->booking->booking_status == -1)
                                        <span style="background-color:saddlebrown" class="badge text-white">Waiting for payment</span>
                                    @endif
                                </td>
                                <td class="text-center">Rp. {{ number_format($transaction->booking->total_subtotal, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('user.transactionHistoryDetail', $transaction->id) }}"
                                        class="btn btn-sm btn-primary">Lihat</a>
                                    @if ($transaction->booking->booking_status == -1)
                                        <a href="{{ route('user.paymentTransaction', $transaction->id) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit" style="background-color:saddlebrown"
                                            class="btn btn-sm text-white">Bayar sekarang</i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
