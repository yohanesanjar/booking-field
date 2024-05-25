@extends('user.layouts.main')

@section('content')
    <!-- Header -->
    <header class="ex-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1">
                    <h1>Profile</h1>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header> <!-- end of ex-header -->
    <!-- end of header -->

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="card mb-3" style="max-width: 720px; border: none;">
                <div class="row g-0">
                    <div class="col-md-4 align-self-center">
                        @if ($profile->avatar == null)
                            <img id="avatar-preview" src="{{ asset('img/undraw_profile.svg') }}"
                                class="img-fluid rounded-circle" alt="{{ $profile->username }}">
                        @else
                            <img id="avatar-preview" src="{{ asset('storage/' . $profile->avatar) }}"
                                class="img-fluid rounded-circle" alt="{{ $profile->username }}">
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Information</h5>
                            <hr>
                            <table>
                                <tr>
                                    <td>Nama Lengkap</td>
                                    <td>:</td>
                                    <td>{{ $profile->name }}</td>
                                </tr>
                                <tr>
                                    <td>Username</td>
                                    <td>:</td>
                                    <td>{{ $profile->username }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td>{{ $profile->email }}</td>
                                </tr>
                                <tr>
                                    <td>No. Telepon</td>
                                    <td>:</td>
                                    <td>{{ $profile->phone }}</td>
                                </tr>
                            </table>
                            <hr>
                            <div class="text-end">
                                <a href="{{ route('user.editProfile', $profile->id) }}" class="btn btn-primary">Update
                                    Profile</a>
                            </div>
                        </div>
                    </div>
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
