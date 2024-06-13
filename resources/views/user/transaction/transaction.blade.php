@extends('user.layouts.main')

@section('content')
    <div class="container pt-5 pb-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form class="form-card p-4" action="{{ route('user.storeTransaction') }}" method="POST"
                        enctype="multipart/form-data" onsubmit="removeFormattingBeforeSubmit(this)">
                        @csrf
                        <input type="hidden" name="field_data_id" value="{{ $bookingData['field_data_id'] }}">

                        <input type="hidden" name="customer_name" value="{{ $bookingData['customer_name'] }}">
                        <input type="hidden" name="is_member" value="{{ $bookingData['is_member'] }}">
                        <input type="hidden" name="schedule_play"
                            value="{{ $bookingData['selected_schedules'][0]['schedule_play'] }}">
                        @foreach ($bookingData['selected_schedules'] as $schedule)
                            <input type="hidden" name="selected_schedules[]" value="{{ $schedule['field_schedule_id'] }}">
                        @endforeach
                        <div class="row">
                            <div class="form-group col-12 flex-column d-flex">
                                <h4>{{ $fieldData->name }} | {{ $fieldData->field_type }}</h4>
                            </div>
                            <hr style="border-top: 2px solid #000;">
                            <div class="form-group col-12 flex-column d-flex">
                                <p>Nama Pemesan : {{ $bookingData['customer_name'] }}</p>
                                <p>Member : {{ $bookingData['is_member'] == 1 ? 'Ya' : 'Tidak' }}</p>
                            </div>
                            <div class="form-group col-12 flex-column d-flex">
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
                                        @endphp
                                        @foreach ($bookingData['selected_schedules'] as $data)
                                            <tr>
                                                <td class="text-center">
                                                    @if ($lastSchedule !== $data['schedule_play'])
                                                        {{ $data['schedule_play'] }}
                                                        @php
                                                            $lastSchedule = $data['schedule_play'];
                                                        @endphp
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $data['start_time'] }} -
                                                    {{ $data['end_time'] }}
                                                </td>
                                                <td class="text-center">Rp
                                                    {{ number_format($data['sub_total'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($bookingData['is_member'] == 1)
                                            <tr>
                                                <td class="text-center" colspan="2">Total</td>
                                                <td class="text-center">Rp
                                                    {{ number_format($bookingData['total_before_discount'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center" colspan="2">Diskon Member</td>
                                                <td>Rp. {{ number_format($bookingData['discount'], 0, ',', '.') }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="text-center" colspan="2"><strong>Total Bayar</strong></td>
                                            <td class="text-center"><strong>Rp
                                                    {{ number_format($bookingData['total_after_discount'], 0, ',', '.') }}</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr style="border-top: 2px solid #000;">
                            @if ($bookingData['is_member'] == false)
                                <div class="form-group col-12 flex-column d-flex">
                                    <label for="down_payment" class="form-control-label">Uang Muka</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" id="down_payment" name="down_payment" class="form-control"
                                            placeholder="Masukkan Jumlah Uang Muka" oninput="formatCurrency(this)">
                                    </div>
                                    @error('down_payment')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif
                            <div class="form-group col-12 flex-column d-flex">
                                <label class="form-control-label">Jenis Pembayaran<span class="text-danger">*</span></label>
                                <select class="form-select @error('payment_method') is-invalid @enderror"
                                    aria-label="payment_method" id="payment_method" name="payment_method"
                                    onchange="showHidePaymentFields()">
                                    <option selected disabled>- Pilih jenis pembayaran -</option>
                                    @foreach ($paymentMethods as $pm)
                                        <option value="{{ $pm->id }}"
                                            {{ old('payment_method') == $pm->name ? 'selected' : '' }}>
                                            {{ $pm->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('payment_method')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row justify-content-end py-4 pe-4">
                                <div class="form-group col-sm-1 ">
                                    <button type="submit" class="btn-solid-small">Create</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function formatCurrency(input) {
            // Remove non-numeric characters
            let numericValue = input.value.replace(/[^0-9]/g, '');

            // Format the value with commas for thousands
            let formattedValue = new Intl.NumberFormat('id-ID').format(numericValue);

            // Add the "Rp" prefix
            formattedValue = formattedValue;

            // Update the input value
            input.value = formattedValue;
        }

        // Remove formatting before submitting the form
        function removeFormattingBeforeSubmit(form) {
            let priceInput2 = form.elements['down_payment'];
            priceInput2.value = priceInput2.value.replace(/[^0-9]/g, '');
        }
    </script>
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'error',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif
@endsection
