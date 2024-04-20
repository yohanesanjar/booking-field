@extends('admin.layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profile</h1>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="row g-0">
                <div class="col-md-4 align-self-center">
                    <form class="user" action="{{ route('admin.updateProfile', $profile->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @if ($profile->avatar == null)
                            <img style="height: 21rem; width: 30rem" id="avatar-preview" src="{{ asset('userLib2/images/details-modal.jpg') }}"
                                class="img-fluid rounded-circle" alt="{{ $profile->username }}">
                        @else
                            <img style="height: 21rem; width: 30rem" id="avatar-preview" src="{{ asset('storage/' . $profile->avatar) }}"
                                class="img-fluid rounded-circle" alt="{{ $profile->username }}">
                        @endif
                        <div class="mt-3">
                            <input type="file" name="avatar" class="form-control-file" onchange="previewAvatar(this)">
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
                                aria-describedby="phone" value="{{ $profile->phone }}" placeholder="Enter phone number..."
                                min="0">
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
