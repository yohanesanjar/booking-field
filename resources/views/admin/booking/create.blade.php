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
                <form class="form-card p-4" action="{{ route('admin.getSession') }}" method="POST"
                    enctype="multipart/form-data" onsubmit="removeFormattingBeforeSubmit(this)">
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
                            <h6><strong>Jam Pagi : Rp {{ number_format($fieldData->morning_price, 0, ',', '.') }}</strong>
                            </h6>
                            <h6><strong>Jam Malam : Rp {{ number_format($fieldData->night_price, 0, ',', '.') }}</strong>
                            </h6>
                        </div>
                    </div>
                    <hr style="border-top: 2px solid #000;">
                    @if ($fieldData->field_type == 'Bulu Tangkis')
                        <div class="form-group col-12 flex-column d-flex">
                            <label for="">Notes</label>
                            <p>Jika ingin menjadi member anda harus memilih jam bermain selama 3 jam. Member akan bermain
                                sebanyak 4 kali selama 1 bulan pada hari dan di jam yang telah dipilih. Harga bermain untuk
                                member adalah Rp. 275.000</p>
                        </div>
                        <div class="form-group col-12 flex-column d-flex ps-4">
                            <input class="form-check-input" type="checkbox" name="is_member" value="1" id="is_member">
                            <label class="form-check-label" for="is_member">
                                Apakah anda ingin menjadi member
                            </label>
                        </div>
                        <hr style="border-top: 2px solid #000;">
                    @endif
                    {{-- <div class="form-group col-12 flex-column d-flex">
                    </div> --}}
                    <div class="form-group col-12 flex-column d-flex">
                        <label for="customer_name" class="form-control-label">Nama Pemesan<span class="text-danger"> *
                                </span"></label>
                        <input type="text" id="customer_name" name="customer_name" class="form-control">
                        @error('customer_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-12 flex-column d-flex">
                        <label class="form-control-label">Jadwal Main<span class="text-danger"> *</span></label>
                        <input type="text" id="schedule_play" value="{{ $schedule_play }}" name="schedule_play"
                            class="form-control">
                        @error('schedule_play')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row justify-content-between text-left" id="schedule_result">
                        <div class="form-group d-flex flex-row flex-wrap">
                            @foreach ($fieldSchedules as $fs)
                                @if ($fs->is_active == 1)
                                    <div class="col-4">
                                        <input class="btn-check" type="checkbox" value="{{ $fs->id }}"
                                            name="selected_schedules[]" id="schedule_{{ $fs->id }}"
                                            @if ($fs->scheduleAvailabilities->isNotEmpty() && !$fs->scheduleAvailabilities->first()->is_available) disabled @endif>
                                        <label class="btn btn-outline-primary w-100" for="schedule_{{ $fs->id }}">
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
                            {{-- <button type="button" class="btn-block btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" data-bs-whatever="@mdo">Create</button> --}}
                            <button type="submit" class="btn-block btn-primary">Create</button>
                        </div>
                    </div>
                    {{-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Transaksi</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <div class="row justify-content-between text-left py-4" style="display: none;"
                                            id="transaksi">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Nama Lapangan</th>
                                                        <th scope="col">Jadwal</th>
                                                        <th scope="col">Sub Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="discount" class="form-control-label">Diskon</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" id="discount" name="discount" class="form-control"
                                                placeholder="Masukkan Jumlah Diskon" oninput="formatCurrency(this)">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-control-label">Jenis Pembayaran<span class="text-danger">
                                                *</span></label>
                                        <select class="form-select @error('payment_method') is-invalid @enderror"
                                            aria-label="payment_method" id="payment_method" name="payment_method">
                                            <option selected disabled>- Pilih jenis pembayaran -</option>
                                            @foreach ($paymentMethods as $pm)
                                                <option value="{{ $pm->id }}"
                                                    {{ old('payment_method') == $pm->name ? 'selected' : '' }}>
                                                    {{ $pm->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('payment_method')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="account_name" class="form-control-label">Nama Pengirim<span
                                                class="text-danger">
                                                *</span></label>
                                        <input type="text" id="account_name" name="account_name"
                                            class="form-control">
                                        @error('account_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="payment_proof">Bukti Pembayaran<span class="text-danger">
                                                *</span></label>
                                        <input class="form-control" type="file" name="payment_proof"
                                            id="payment_proof" onchange="previewPaymentProof(this)">
                                        <img id="payment-proof-preview" class="py-4"
                                            src="{{ asset('storage/' . $fieldData->thumbnail) }}" alt="Current Thumbnail"
                                            style="width: 100px;">
                                        @error('payment_proof')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Book Now</button>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </form>
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
                    url: "{{ route('check.availability') }}",
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
    <script type="text/javascript">
        $(function() {
            // Event listener untuk checkbox
            $('input[name="selected_schedules[]"]').on('change', function() {
                updateTransactionTable();
            });

            function updateTransactionTable() {
                // Mendapatkan jumlah checkbox yang dicek
                var checkedCount = $('input[name="selected_schedules[]"]:checked').length;

                // Jika ada jadwal yang dipilih, tampilkan tabel transaksi, jika tidak, sembunyikan
                if (checkedCount > 0) {
                    $('#transaksi').show();
                } else {
                    $('#transaksi').hide();
                }

                // Kosongkan isi tabel transaksi sebelum memperbarui
                $('#transaksi tbody').empty();

                var total = 0;

                // Iterasi melalui setiap checkbox yang dipilih
                $('input[name="selected_schedules[]"]:checked').each(function() {
                    var scheduleId = $(this).val();
                    var scheduleLabel = $(this).siblings('label').text().trim();
                    var subTotal;

                    if (scheduleId <= 11) {
                        subTotal = parseFloat('{{ $fieldData->morning_price }}');
                    } else {
                        subTotal = parseFloat('{{ $fieldData->night_price }}');
                    }

                    // Ubah format subTotal menjadi mata uang Rupiah
                    var subTotalRp = formatRupiah(subTotal);

                    // Tambahkan baris baru ke dalam tabel transaksi
                    $('#transaksi tbody').append(
                        '<tr>' +
                        '<td>{{ $fieldData->name }}</td>' +
                        '<td>' + scheduleLabel + '</td>' +
                        '<td>Rp ' + subTotalRp + '</td>' +
                        '</tr>'
                    );

                    // Tambahkan subtotal ke total
                    total += subTotal;
                });

                // Ubah format total menjadi mata uang Rupiah
                var totalRp = formatRupiah(total);

                // Tambahkan baris total ke dalam tabel transaksi
                $('#transaksi tbody').append(
                    '<tr>' +
                    '<td colspan="2" class="text-right">Total</td>' +
                    '<td>Rp ' + totalRp + '</td>' + // Format total sebagai mata uang Rupiah
                    '</tr>'
                );
            }
            // Fungsi untuk memformat angka sebagai mata uang Rupiah
            function formatRupiah(angka) {
                var reverse = angka.toString().split('').reverse().join(''),
                    ribuan = reverse.match(/\d{1,3}/g);
                ribuan = ribuan.join('.').split('').reverse().join('');
                return ribuan;
            }


        });
    </script>
    <script>
        // Function to preview the selected image
        function previewPaymentProof(input) {
            var preview = document.getElementById('payment-proof-preview');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
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
            let priceInput = form.elements['discount'];
            priceInput.value = priceInput.value.replace(/[^0-9]/g, '');
        }
    </script>
@endsection
