@extends('admin.layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Transaksi</h1>
    </div>
    <div class="row">
        <div class="row">
            <div class="col text-start py-3">
                <input type="text" id="daterange" name="daterange" />
            </div>
            <div class="col text-end py-3">
                <a id="exportPDFButton" class="btn btn-primary">Export to PDF</a>
            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Transaksi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalTransaction">Rp.
                                    {{ number_format($totalTransaction, 0, ',', '.') }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="paymentMethods">
            @foreach ($totals as $paymentMethodName => $totalAmount)
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        {{ $paymentMethodName }}</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.
                                        {{ number_format($totalAmount, 0, ',', '.') }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success d-flex justify-content-between align-items-center">
            {{ session('success') }}
            <button type="button" class="btn-close flex-end" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col">
            <table class="table table-hover text-nowrap" id="myTable" style="width: 100%">
                <thead>
                    <tr>
                        <th class="text-center">ID Transaksi</th>
                        <th class="text-center">ID Booking</th>
                        <th class="text-center">Nama Pemesan</th>
                        <th class="text-center">Tanggal Transaksi</th>
                        <th class="text-center">Nama Lapangan</th>
                        <th class="text-center">Jenis Lapangan</th>
                        <th class="text-center">Total Pembayaran</th>
                        <th class="text-center">Sudah Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td class="text-center">{{ $transaction->id }}</td>
                            <td class="text-center">{{ $transaction->booking_id }}</td>
                            <td class="text-center">{{ $transaction->booking->customer_name }}</td>
                            <td class="text-center">{{ $transaction->created_at }}</td>
                            <td class="text-center">{{ $transaction->booking->fieldData->name }}</td>
                            <td class="text-center">{{ $transaction->booking->fieldData->field_type }}</td>
                            <td class="text-center"><span class="badge text-bg-primary text-white">Rp.
                                    {{ number_format($transaction->booking->total_subtotal, 0, ',', '.') }}</span></td>
                            <td class="text-center"><span class="badge text-bg-success text-white">Rp
                                    {{ number_format($transaction->total_payment, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function() {
            $('#daterange').daterangepicker({
                opens: 'right',
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, function(start, end, label) {
                loadTransactions(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            });

            $('#exportPDFButton').click(function() {
                // Ambil nilai terbaru dari date range picker
                var startDate = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var endDate = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');

                // Buat URL dengan nilai start_date dan end_date yang diperbarui
                var exportPDFUrl = '{{ route('admin.transactionExportPDF') }}?start_date=' + startDate +
                    '&end_date=' + endDate;

                // Redirect ke halaman PDF
                window.location.href = exportPDFUrl;
            });
            // Function to load transactions via Ajax
            function loadTransactions(startDate, endDate) {
                $.ajax({
                    url: '{{ route('admin.loadTransactions') }}',
                    type: 'GET',
                    data: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(response) {
                        $('#myTable').DataTable().destroy();
                        $('#myTable').DataTable({
                            data: response.transactions,
                            columns: [{
                                    data: 'id',
                                    className: 'text-center'
                                },
                                {
                                    data: 'booking_id',
                                    className: 'text-center'
                                },
                                {
                                    data: 'booking.customer_name',
                                    className: 'text-center'
                                },
                                {
                                    data: 'created_at',
                                    className: 'text-center',
                                    render: function(data, type, row) {
                                        // Mengubah data tanggal ke dalam objek Date
                                        var date = new Date(data);

                                        // Array untuk menyimpan nama hari dalam bahasa Inggris
                                        var days = ['Minggu', 'Senin', 'Selasa', 'Rabu',
                                            'Kamis', 'Jumat', 'Sabtu'
                                        ];

                                        // Mendapatkan nama hari berdasarkan tanggal
                                        var dayName = days[date.getDay()];

                                        // Mendapatkan tanggal dalam format dd/mm/yyyy
                                        var formattedDate = ('0' + date.getDate())
                                            .slice(-2) + '/' + ('0' + (date.getMonth() +
                                                1)).slice(-2) + '/' + date
                                            .getFullYear();

                                        // Mengembalikan tanggal yang diformat
                                        return dayName + ', ' + formattedDate;
                                    }
                                },
                                {
                                    data: 'booking.field_data.name',
                                    className: 'text-center'
                                },
                                {
                                    data: 'booking.field_data.field_type',
                                    className: 'text-center'
                                },
                                {
                                    data: 'booking.total_subtotal',
                                    className: 'text-center',
                                    render: function(data, type, row) {
                                        // Menggunakan number_format untuk format Rupiah tanpa koma
                                        var formattedTotal = 'Rp ' + Number(data)
                                            .toLocaleString('id-ID', {
                                                minimumFractionDigits: 0
                                            });
                                        return formattedTotal;
                                    }
                                },
                                {
                                    data: 'total_payment',
                                    className: 'text-center',
                                    render: function(data, type, row) {
                                        // Menggunakan number_format untuk format Rupiah tanpa koma
                                        var formattedTotal = 'Rp ' + Number(data)
                                            .toLocaleString('id-ID', {
                                                minimumFractionDigits: 0
                                            });
                                        return formattedTotal;
                                    }
                                },
                            ],
                            responsive: true,
                            scrollX: true,
                            order: [],
                        });

                        $('#paymentMethods').empty();
                        $.each(response.totals, function(paymentMethodName, totalAmount) {
                            var formattedTotal = 'Rp ' + Number(totalAmount).toLocaleString(
                                'id-ID', {
                                    minimumFractionDigits: 0
                                });
                            $('#paymentMethods').append(
                                '<div class="col-xl-3 col-md-6 mb-4">' +
                                '<div class="card border-left-primary shadow h-100 py-2">' +
                                '<div class="card-body">' +
                                '<div class="row no-gutters align-items-center">' +
                                '<div class="col mr-2">' +
                                '<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">' +
                                paymentMethodName +
                                '</div>' +
                                '<div class="h5 mb-0 font-weight-bold text-gray-800">' +
                                formattedTotal +
                                '</div>' +
                                '</div>' +
                                '<div class="col-auto">' +
                                '<i class="fas fa-money-bill fa-2x text-gray-300"></i>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>'
                            );
                        });

                        $('#totalTransaction').empty();
                        var formattedTotalTransaction = 'Rp ' + Number(response.totalTransaction)
                            .toLocaleString(
                                'id-ID', {
                                    minimumFractionDigits: 0
                                });
                        $('#totalTransaction').append(
                            formattedTotalTransaction
                        );
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            }
        });
    </script>
@endsection
