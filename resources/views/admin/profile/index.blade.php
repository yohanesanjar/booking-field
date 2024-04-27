@extends('admin.layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profile</h1>
    </div>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="row g-0">
                <div class="col-md-4 align-self-center">
                    @if ($profile->avatar == null)
                        <img style="height: 21rem; width: 30rem" id="avatar-check" src="{{ asset('img/undraw_profile.svg') }}"
                            class="avatar-check img-fluid rounded-circle" alt="{{ $profile->username }}">
                    @else
                        <img style="height: 21rem; width: 30rem" id="avatar-preview"
                            src="{{ asset('storage/' . $profile->avatar) }}" class="avatar-check img-fluid rounded-circle"
                            alt="{{ $profile->username }}">
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Information</h5>
                        <hr style=" border-top: 2px solid #000;">
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
                        <hr style=" border-top: 2px solid #000;">
                        <div class="text-end">
                            <a href="{{ route('admin.editProfile', $profile->id) }}" class="btn btn-primary">Update
                                Profile</a>
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
