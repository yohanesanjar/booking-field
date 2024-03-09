@extends('admin.layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Jenis Lapangan</h1>
    </div>
    @if (session('success'))
        <div class="alert alert-success d-flex justify-content-between align-items-center">
            {{ session('success') }}
            <button type="button" class="btn-close flex-end" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="py-3">
        <a href="{{ route('owner.fieldCreate') }}" class="btn btn-primary">Tambah</a>
    </div>
    <!-- Content Row -->
    <div class="row">

        <!-- Area Chart -->
        <div class="col">
            <table class="table table-hover text-nowrap" id="myTable" style="width: 100%">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Aksi</th>
                        <th class="text-center">Thumbnail</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Deskripsi</th>
                        <th class="text-center">Jenis Lapangan</th>
                        <th class="text-center">Material Lapangan</th>
                        <th class="text-center">Lokasi Lapangan</th>
                        <th class="text-center">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fieldData as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $data->id }} "><i class="fa fa-eye"></i></a>

                                    {{-- Modal --}}
                                    <div class="modal fade" id="detailModal{{ $data->id }}" tabindex="-1"
                                        aria-labelledby="detailModal{{ $data->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="detailModal{{ $data->id }}">Data
                                                        Lapangan</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="mb-3">
                                                            <label for="recipient-name"
                                                                class="col-form-label">Recipient:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="message-text"
                                                                class="col-form-label">Message:</label>
                                                            <textarea class="form-control" id="message-text"></textarea>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Send message</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <a href="{{ route('owner.fieldEdit', $data->id) }}" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="Edit" class="btn btn-sm btn-warning"><i
                                            class="fa fa-edit"></i>
                                    </a>

                                    <form class="deleteForm" action="{{ route('owner.fieldDelete', $data->id) }}"
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
                            <td><img src="{{ asset('storage/' . $data->thumbnail) }}" style="width: 100px"
                                    alt="{{ $data->thumbnail }}"></td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->description }}</td>
                            <td>{{ $data->field_type }}</td>
                            <td>{{ $data->field_material }}</td>
                            <td>{{ $data->field_location }}</td>
                            <td>Rp {{ number_format($data->price, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

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
