@extends('admin.layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data Booking</h1>
    </div>
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
                <form id="dateFilterForm" method="GET" action="{{ route('dateFilter', $fieldData->id) }}">
                    <div class="form-group col-12 flex-column d-flex">
                        <label class="form-control-label">Jadwal Main<span class="text-danger"> *</span></label>
                        <input type="text" id="schedule_play" value="{{ old('schedule_play') }}" name="schedule_play" class="form-control">
                        @error('schedule')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
                <form class="form-card p-4" action="{{ route('owner.bookingStore') }}" method="POST"
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
                            <h6><strong>Rp {{ number_format($fieldData->price, 0, ',', '.') }}</strong></h6>
                        </div>
                    </div>
                    <hr style="border-top: 2px solid #000;">
                    <input type="date" name="schedule" id="schedule" value="{{ $selectedDate }}" class="form-control"
                        readonly>
                    <div class="row justify-content-between text-left">
                        @foreach ($fieldSchedules as $fs)
                            @if ($fs->is_active == 1)
                                {{-- @php
                                    $availability = $fs->scheduleAvailabilities
                                        ->where('field_data_id', $fieldData->id)
                                        ->where('schedule_date', $selectedDate)
                                        ->first();
                                @endphp --}}
                                <div class="form-group col-12 flex-column d-flex">
                                    <input class="form-check-input" type="checkbox" value="{{ $fs->id }}"
                                        name="selected_schedules[]" id="flexCheckChecked">
                                    <label class="form-check-label" for="flexCheckChecked">
                                        {{ $fs->start_time }} - {{ $fs->end_time }}
                                    </label>
                                </div>
                            @endif
                        @endforeach
                        @error('selected_schedules')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row justify-content-end py-4 px-4">
                        <div class="form-group col-sm-2">
                            <button type="submit" class="btn-block btn-primary">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function() {
            $("#schedule_play").datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: 0,
                onSelect: function(dateText) {
                    // Mengirimkan formulir secara otomatis saat pengguna memilih tanggal
                    $('#dateFilterForm').submit();
                }
            });
        });
    </script>
    <script>
        // Tambahkan event listener untuk perubahan nilai pada input schedule_play
        document.getElementById('schedule_play').addEventListener('change', function() {
            // Ambil nilai dari input schedule_play
            var schedulePlayValue = this.value;
            // Set nilai input schedule dengan nilai dari input schedule_play
            document.getElementById('schedule').value = schedulePlayValue;
        });
    </script>
@endsection
