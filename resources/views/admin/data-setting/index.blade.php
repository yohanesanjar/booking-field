@extends('admin.layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Setting</h1>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="row g-0">
                <div class="col-md-4 align-self-center">


                </div>
                <div class="col-md-12">
                    <form class="user" action="{{ route('admin.updateIndexData', $data->id) }}" method="POST"
                        enctype="multipart/form-data">
                        <div class="card-body">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <input type="text" name="address" class="form-control form-control-user" id="address"
                                    aria-describedby="address" value="{{ $data->address }}"
                                    placeholder="Masukkan alamat lengkap...">
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="number" name="phone" class="form-control form-control-user" id="phone"
                                    aria-describedby="phone" value="{{ $data->phone }}"
                                    placeholder="Masukkan nomor telepon..." min="0">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-user" id="email"
                                    aria-describedby="email" value="{{ $data->email }}" placeholder="Masukkan email...">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <hr>
                            <div class="form-group text-end pe-3">
                                <button type="submit" class="btn btn-primary btn-sm btn-block">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif
@endsection
