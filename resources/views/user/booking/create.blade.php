@extends('user.layouts.main')

@section('content')
    <div class="container pt-4">
        <!-- Header -->
        <header class="ex-header">
            <div class="container">
                <div class="row">
                    <div class="col-xl-10 offset-xl-1">
                        <h1>Booking</h1>
                    </div> <!-- end of col -->
                </div> <!-- end of row -->
            </div> <!-- end of container -->
        </header> <!-- end of ex-header -->
        <!-- end of header -->
        @if (session('error'))
            <div class="alert alert-danger d-flex justify-content-between align-items-center">
                {{ session('error') }}
                <button type="button" class="btn-close flex-end" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form class="form-card p-4" action="{{ route('user.getSession') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ asset('storage/' . $fieldData->thumbnail) }}" class="img-fluid"
                                    style="height: 200px; width: 550px" alt="{{ $fieldData->name }}">
                            </div>
                            <div class="col-md-6 p-3">
                                <h4>{{ $fieldData->name }}</h4>
                                <hr style="border-top: 1px solid #000;">
                                <p>{{ $fieldData->description }}</p>
                                <input type="hidden" name="field_data_id" value="{{ $fieldData->id }}">
                                <hr style="border-top: 1px solid #000;">
                                <p>Jenis Lapangan : {{ $fieldData->field_type }}</p>
                                <p>Jenis Material : {{ $fieldData->field_material }}</p>
                                <p>Lokasi Lapangan : {{ $fieldData->field_location }}</p>
                                <hr style="border-top: 1px solid #000;">
                                <h6><strong>Jam Pagi : Rp
                                        {{ number_format($fieldData->morning_price, 0, ',', '.') }}</strong>
                                </h6>
                                <h6><strong>Jam Malam : Rp
                                        {{ number_format($fieldData->night_price, 0, ',', '.') }}</strong>
                                </h6>
                            </div>
                        </div>
                        <hr style="border-top: 2px solid #000;">
                        @if ($fieldData->field_type == 'Bulu Tangkis')
                            <div class="form-group col-12 flex-column d-flex">
                                <label for="">Notes</label>
                                <p>Jika ingin menjadi member anda harus memilih jam bermain selama 3 jam. Member akan
                                    bermain
                                    sebanyak 4 kali selama 1 bulan pada hari dan di jam yang telah dipilih. Harga bermain
                                    untuk
                                    member adalah Rp. 275.000</p>
                            </div>
                            <div class="form-group col-12 flex-column d-flex ps-4">
                                <input class="form-check-input" type="checkbox" name="is_member" value="1"
                                    id="is_member">
                                <label class="form-check-label" for="is_member">
                                    Apakah anda ingin menjadi member
                                </label>
                            </div>
                            <hr style="border-top: 2px solid #000;">
                        @endif
                        <input type="hidden" id="customer_name" name="customer_name" value="{{ Auth::user()->name }}">
                        <div class="form-group col-12 flex-column d-flex">
                            <label class="form-control-label">Jadwal Main<span class="text-danger"> *</span></label>
                            <input type="text" id="schedule_play" value="{{ $schedule_play }}" name="schedule_play"
                                class="form-control">
                            @error('schedule_play')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row justify-content-between" id="schedule_result">
                            <div class="form-group d-flex flex-row flex-wrap">
                                @foreach ($fieldSchedules as $fs)
                                    @if ($fs->is_active == 1)
                                        <div class="schedule col-4 px-1 py-1">
                                            <input class="btn-check" type="checkbox" value="{{ $fs->id }}"
                                                name="selected_schedules[]" id="schedule_{{ $fs->id }}"
                                                @if ($fs->scheduleAvailabilities->isNotEmpty() && !$fs->scheduleAvailabilities->first()->is_available) disabled @endif>
                                            <label class="btn btn-outline-primary w-100"
                                                for="schedule_{{ $fs->id }}">
                                                {{ substr($fs->start_time, 0, 5) }} - {{ substr($fs->end_time, 0, 5) }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            @error('selected_schedules')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <hr style="border-top: 2px solid #000;">
                        <div class="row justify-content-end py-4 px-4">
                            <div class="form-group col-sm-2">
                                <button type="submit" class="btn-solid-small">Book Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            // Inisialisasi datepicker
            $("#schedule_play").datepicker({
                dateFormat: 'yy-mm-dd', // Format tanggal yang diharapkan
                minDate: 0, // Tanggal minimum yang dapat dipilih adalah hari ini
                onSelect: function(selectedDate) {
                    checkAvailability(selectedDate);
                }
            });

            function checkAvailability(selectedDate) {
                let fieldDataId = $('input[name="field_data_id"]').val();

                $.ajax({
                    url: "{{ route('user.checkAvailability') }}",
                    method: "GET",
                    data: {
                        schedule_play: selectedDate,
                        field_data_id: fieldDataId
                    },
                    success: function(response) {
                        // Kosongkan area tampilan sebelum menambahkan data baru
                        $('#schedule_result').empty();

                        var scheduleGroupHtml = '<div class="form-group d-flex flex-row flex-wrap">';

                        // Loop melalui setiap jadwal dan tambahkan ke dalam DOM
                        response.forEach(function(schedule) {
                            if (schedule.is_active == 1) {
                                var startTime = schedule.start_time.substring(0, 5);
                                var endTime = schedule.end_time.substring(0, 5);
                                var scheduleHtml = '<div class="col-4">';
                                scheduleHtml +=
                                    '<input class="btn-check" type="checkbox" value="' +
                                    schedule.id +
                                    '" name="selected_schedules[]" id="schedule_' + schedule
                                    .id + '"';

                                // Periksa apakah schedule_availabilities tidak kosong dan is_available == 0
                                if (schedule.schedule_availabilities.length > 0 && !schedule
                                    .schedule_availabilities[0].is_available) {
                                    scheduleHtml +=
                                        ' disabled'; // Tambahkan atribut disabled jika is_available == 0
                                }

                                scheduleHtml += '>';
                                scheduleHtml +=
                                    '<label class="btn btn-outline-primary w-100" for="schedule_' +
                                    schedule.id + '">';
                                scheduleHtml += startTime + ' - ' + endTime;
                                scheduleHtml += '</label></div>';

                                // Tambahkan elemen ke dalam variabel scheduleGroupHtml
                                scheduleGroupHtml += scheduleHtml;
                            }
                        });

                        scheduleGroupHtml += '</div>';

                        // Tambahkan elemen group ke dalam DOM
                        $('#schedule_result').append(scheduleGroupHtml);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    </script>
@endsection
