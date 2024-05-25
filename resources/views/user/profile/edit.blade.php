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
                        <form class="user" action="{{ route('user.updateProfile', $profile->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @if ($profile->avatar == null)
                                <img id="avatar-preview" style="height: 225px; width: 500px;"
                                    src="{{ asset('img/undraw_profile.svg') }}" class="img-fluid rounded-circle"
                                    alt="{{ $profile->username }}">
                            @else
                                <img id="avatar-preview" src="{{ asset('storage/' . $profile->avatar) }}" class="img-fluid rounded-circle"
                                    alt="{{ $profile->username }}">
                            @endif
                            <div class="mt-3">
                                <input type="file" name="avatar" class="form-control-file"
                                    onchange="previewAvatar(this)">
                                @error('avatar')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Information</h5>
                            <hr>

                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <input type="text" name="name" class="form-control form-control-user" id="name"
                                    aria-describedby="name" value="{{ $profile->name }}" placeholder="Enter full name...">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" name="username" class="form-control form-control-user" id="username"
                                    aria-describedby="username" value="{{ $profile->username }}"
                                    placeholder="Enter username...">
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-user" id="email"
                                    aria-describedby="email" value="{{ $profile->email }}" placeholder="Enter email...">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="number" name="phone" class="form-control form-control-user" id="phone"
                                    aria-describedby="phone" value="{{ $profile->phone }}"
                                    placeholder="Enter phone number..." min="0">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-user"
                                    id="exampleInputPassword" placeholder="Enter new password...">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <hr>
                            <div class="form-group text-end pe-3">
                                <button type="submit" class="btn-solid-small">
                                    Update
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // Function to preview the selected image
        function previewAvatar(input) {
            var preview = document.getElementById('avatar-preview');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
