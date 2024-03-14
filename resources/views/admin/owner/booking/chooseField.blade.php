@extends('admin.layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pilih Lapangan</h1>
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
                        <th class="text-center">#</th>
                        <th class="text-center">Nama Lapangan</th>
                        <th class="text-center">Jenis Lapangan</th>
                        <th class="text-center">Jenis Material</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fieldDatas as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->field_type }}</td>
                            <td>{{ $data->field_material }}</td>
                            <td>Rp {{ number_format($data->price, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $data->id }} "><i class="fa fa-eye"></i></a>

                                    {{-- Modal --}}
                                    <div class="modal fade" id="detailModal{{ $data->id }}" tabindex="-1"
                                        aria-labelledby="detailModal{{ $data->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="detailModal{{ $data->id }}">Data
                                                        Lapangan</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <img src="{{ asset('storage/' . $data->thumbnail) }}"
                                                                style="width: 150px" alt="{{ $data->thumbnail }}">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col text-start">
                                                            <label for="message-text" class="col-label">Nama:</label>
                                                            <p>{{ $data->name }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col text-start">
                                                            <label for="message-text" class="col-label">Deskripsi
                                                                Lapangan:</label>
                                                            <p>{{ $data->description }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 text-start">
                                                        <div class="col-4">
                                                            <label for="message-text" class="col-label">Jenis
                                                                Lapangan:</label>
                                                            <p>{{ $data->field_type }}</p>
                                                        </div>
                                                        <div class="col-4">
                                                            <label for="message-text" class="col-label">Material
                                                                Lapangan:</label>
                                                            <p>{{ $data->field_material }}</p>
                                                        </div>
                                                        <div class="col-4">
                                                            <label for="message-text" class="col-label">Lokasi
                                                                Lapangan:</label>
                                                            <p>{{ $data->field_location }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col text-start">
                                                            <label for="message-text" class="col-label">Harga:</label>
                                                            <p>Rp. {{ number_format($data->price, 0, ',', '.') }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <a href="{{ route('owner.fieldEdit', $data->id) }}"
                                                        class="btn btn-warning">Edit</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <a href="{{ route('owner.bookingCreate', $data->id) }}" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="Edit" class="btn btn-sm btn-warning">pilih</i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection