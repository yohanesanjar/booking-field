@extends('user.layouts.main')

@section('content')
    <div class="container py-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="form-group col-md-12 flex-column d-flex pt-5 ps-5">
                            <h2>Invoice | {{ $transaction->id }}</h2>
                        </div>
                        <div class="form-group col-12 flex-column d-flex ps-5">
                            @php
                                function translateDay($englishDay)
                                {
                                    $days = [
                                        'Monday' => 'Senin',
                                        'Tuesday' => 'Selasa',
                                        'Wednesday' => 'Rabu',
                                        'Thursday' => 'Kamis',
                                        'Friday' => 'Jumat',
                                        'Saturday' => 'Sabtu',
                                        'Sunday' => 'Minggu',
                                    ];

                                    return $days[$englishDay];
                                }

                                $date = $transaction->created_at;
                                $day = translateDay($date->format('l'));
                                $dateFormatted = $day . ', ' . $date->format('j F Y');
                            @endphp
                            <h5>{{ $dateFormatted }}</h5>
                        </div>
                        <div class="form-group col-lg-3 flex-column d-flex px-5">
                            @if ($transaction->booking->booking_status == 0)
                                <span class="badge text-bg-danger text-white">Invalid</span>
                            @elseif ($transaction->booking->booking_status == 1)
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
                        </div>
                        <div class="hr">
                            <hr style="border-top: solid #000;">
                        </div>
                        <div class="form-group col-md-6 flex-column d-flex ps-5 pt-5">
                            <table class="table-responsive">
                                <tr>
                                    <td>
                                        <h6>Nama Pemesan</h6>
                                    </td>
                                    <td>
                                        <h6>:</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $transaction->booking->customer_name }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>Nama Lapangan</h6>
                                    </td>
                                    <td>
                                        <h6>:</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $transaction->booking->fieldData->name }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>Jenis Lapangan</h6>
                                    </td>
                                    <td>
                                        <h6>:</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $transaction->booking->fieldData->field_type }}</h6>
                                    </td>
                                </tr>
                                @if ($transaction->booking->is_member == 1)
                                    <tr>
                                        <td>
                                            <h6>Pembayaran</h6>
                                        </td>
                                        <td>
                                            <h6>:</h6>
                                        </td>
                                        <td>
                                            <h6>Rp. {{ number_format($transaction->down_payment, 0, ',', '.') }} | {{ $transaction->paymentMethodDP->name }}</h6>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>
                                            <h6>DP</h6>
                                        </td>
                                        <td>
                                            <h6>:</h6>
                                        </td>
                                        <td>
                                            <h6>Rp. {{ number_format($transaction->down_payment, 0, ',', '.') }} | {{ $transaction->paymentMethodDP->name }}</h6>
                                        </td>
                                    </tr>
                                @endif
                                @if ($transaction->remaining_payment > 0)
                                    <tr>
                                        <td>
                                            <h6>Pelunasan</h6>
                                        </td>
                                        <td>
                                            <h6>:</h6>
                                        </td>
                                        <td>
                                            <h6>Rp. {{ number_format($transaction->remaining_payment, 0, ',', '.') }} | {{ $transaction->paymentMethodRemaining->name }}</h6>
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="hr">
                            <hr style="border-top: solid #000;">
                        </div>
                        <div class="form-group col-md-12 flex-column d-flex">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col">Jadwal Bermain</th>
                                        <th class="text-center" scope="col">Jam Bermain</th>
                                        <th class="text-center" scope="col">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $lastSchedule = null;
                                        $total = 0;
                                    @endphp
                                    @foreach ($transaction->booking->bookingDetails as $data)
                                        <tr>
                                            <td class="text-center">
                                                @if ($lastSchedule !== $data->schedule_play)
                                                    {{ $data->schedule_play }}
                                                    @php
                                                        $lastSchedule = $data->schedule_play;
                                                    @endphp
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $data->fieldSchedule->start_time }} -
                                                {{ $data->fieldSchedule->end_time }}</td>
                                            </td>
                                            <td class="text-center">Rp
                                                {{ number_format($data->sub_total, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        @php
                                            $total += $data->sub_total;
                                        @endphp
                                    @endforeach
                                    @if ($transaction->booking->is_member == 1)
                                        <tr>
                                            <td class="text-center" colspan="2">Total</td>
                                            <td class="text-center">Rp
                                                {{ number_format($total, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center" colspan="2">Diskon Member</td>
                                            <td class="text-center">Rp.
                                                {{ number_format($transaction->booking->discount, 0, ',', '.') }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="text-center" colspan="2"><strong>Total Bayar</strong></td>
                                        <td class="text-center"><strong>Rp
                                                {{ number_format($transaction->booking->total_subtotal, 0, ',', '.') }}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @if ($transaction->booking->booking_status == -1)
                            <div class="form-group col-md-12 px-5">
                                <a href="{{ route('user.paymentTransaction', $transaction->id) }}"
                                    class="btn btn-primary">Bayar Sekarang</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
