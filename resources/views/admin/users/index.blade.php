@extends('admin.layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data User</h1>
    </div>
    @if (session('success'))
        <div class="alert alert-success d-flex justify-content-between align-items-center">
            {{ session('success') }}
            <button type="button" class="btn-close flex-end" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="py-3">
        <a href="{{ route('admin.userCreate') }}" class="btn btn-primary">Tambah</a>
    </div>
    <!-- Content Row -->
    <div class="row">

        <!-- Area Chart -->
        <div class="col">
            <table class="table table-hover text-nowrap" id="myTable" style="width: 100%">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">Role</th>
                        <th class="text-center">aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $user->name }}</td>
                                <td class="text-center">{{ $user->email }}</td>
                                <td class="text-center">{{ $user->username }}</td>
                                <td class="text-center">{{ $user->role->name }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $user->id }} "><i class="fa fa-eye"></i></a>
    
                                        {{-- Modal --}}
                                        <div class="modal fade" id="detailModal{{ $user->id }}" tabindex="-1"
                                            aria-labelledby="detailModal{{ $user->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="detailModal{{ $user->id }}">Data
                                                            Lapangan</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row mb-2">
                                                            <div class="col text-start">
                                                                <label for="message-text" class="col-label">Nama:</label>
                                                                <p>p</p>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col text-start">
                                                                <label for="message-text" class="col-label">Deskripsi
                                                                    Lapangan:</label>
                                                                <p>p</p>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2 text-start">
                                                            <div class="col-4">
                                                                <label for="message-text" class="col-label">Jenis
                                                                    Lapangan:</label>
                                                                <p>p</p>
                                                            </div>
                                                            <div class="col-4">
                                                                <label for="message-text" class="col-label">Material
                                                                    Lapangan:</label>
                                                                <p>p</p>
                                                            </div>
                                                            <div class="col-4">
                                                                <label for="message-text" class="col-label">Lokasi
                                                                    Lapangan:</label>
                                                                <p>p</p>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col text-start">
                                                                <label for="message-text" class="col-label">Harga Jam Pagi:</label>
                                                                <p>p</p>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col text-start">
                                                                <label for="message-text" class="col-label">Harga Jam Malam:</label>
                                                                <p>p</p>
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <a href="{{ route('admin.fieldEdit', $user->id) }}"
                                                            class="btn btn-warning">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                        <a href="{{ route('admin.userEdit', $user->id) }}" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="Edit" class="btn btn-sm btn-warning"><i
                                                class="fa fa-edit"></i>
                                        </a>
    
                                        <form class="deleteForm" action="{{ route('admin.userDelete', $user->id) }}"
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
    @section('script')
        <script>
            var deleteButtons = document.querySelectorAll('.deleteButton');

            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var form = this.closest('.deleteForm');

                    Swal.fire({
                        title: 'Hapus User',
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