@extends('admin.layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4" id="jadwal">
        <h1 class="h3 mb-0 text-gray-800">Jadwal Lapangan Aktif</h1>
    </div>
    @if (session('success'))
        <div class="alert alert-success d-flex justify-content-between align-items-center">
            {{ session('success') }}
            <button type="button" class="btn-close flex-end" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="text-end" id="removeButtonContainer" style="display: none;">
        <button class="btn btn-primary btn-sm removeAll mb-3">Remove Data</button>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col">
            <table class="table table-hover text-nowrap" id="myTable" style="width: 100%">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center" scope="col">Id Booking</th>
                        <th class="text-center" scope="col">Nama Pelanggan</th>
                        <th class="text-center" scope="col">Jadwal Bermain</th>
                        <th class="text-center" scope="col">Nama Lapangan</th>
                        <th class="text-center" scope="col">Jenis Lapangan</th>
                        <th class="text-center" scope="col">Jam Bermain</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($scheduleAvailable as $schedule)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" class="check" value="{{ $schedule->id }}">
                            </td>
                            <td class="text-center">{{ $schedule->booking->id }}</td>
                            <td class="text-center">{{ $schedule->booking->customer_name }}</td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($schedule->schedule_date)->translatedFormat('l, d F Y') }}</td>
                            <td class="text-center">{{ $schedule->fieldData->name }}</td>
                            <td class="text-center">{{ $schedule->fieldData->field_type }}</td>
                            <td class="text-center">{{ $schedule->fieldSchedule->start_time }} -
                                {{ $schedule->fieldSchedule->end_time }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Event listener untuk checkbox di dalam DataTables
            $('#myTable').on('change', '.check', function() {
                var checkboxes = $('.check:checked'); // Ambil semua checkbox yang dicentang

                // Periksa apakah setidaknya satu checkbox telah dipilih
                if (checkboxes.length > 0) {
                    $('#removeButtonContainer').show(); // Tampilkan tombol Remove Data
                } else {
                    $('#removeButtonContainer').hide(); // Sembunyikan tombol Remove Data
                }
            });

            // Event listener untuk tombol Remove Data
            $('.removeAll').click(function() {
                var ids = []; // Array untuk menyimpan ID data yang akan dihapus

                // Loop melalui setiap checkbox
                $('.check:checked').each(function() {
                    ids.push($(this).val()); // Tambahkan ID data yang dicentang ke dalam array
                });

                // Kirim request Ajax dengan metode DELETE
                $.ajax({
                    type: 'DELETE',
                    url: '{{ route('admin.scheduleActiveDelete') }}',
                    data: {
                        _token: '{{ csrf_token() }}', // Sertakan token CSRF jika dibutuhkan
                        ids: ids // Kirim ID data yang akan dihapus
                    },
                    success: function(response) {
                        // Hapus baris tabel yang sesuai
                        ids.forEach(function(id) {
                            $('#myTable').find('input[value="' + id + '"]').closest(
                                'tr').remove();
                        });

                        $('.alert').remove(); // Hapus alert yang sudah ada jika ada
                        $('#jadwal').after(
                            '<div class="alert alert-success d-flex justify-content-between align-items-center">' +
                            (response.message || 'Data successfully removed') +
                            '<button type="button" class="btn-close flex-end" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                        );
                        $('#removeButtonContainer').hide();
                    },
                    error: function(xhr, status, error) {
                        // Tampilkan pesan kesalahan
                        $('.alert').remove(); // Hapus alert yang sudah ada jika ada
                        $('#jadwal').before(
                            '<div class="alert alert-danger d-flex justify-content-between align-items-center">' +
                            (error.error ||
                                'Schedule cannot be deleted because booking status is already paid'
                            ) +
                            '<button type="button" class="btn-close flex-end" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                        );
                        console.error(error); // Log error jika ada
                    }
                });
            });
        });
    </script>
@endsection
