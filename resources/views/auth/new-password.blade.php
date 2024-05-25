@extends('user.layouts.main')

@section('content')
    <div class="container">
        <div class="card border-0 shadow-lg my-5" style="max-width: 400px; margin: 0 auto;">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <div class="p-5">
                        <div class="text-center">
                            @if (session('error'))
                                <div class="alert alert-danger d-flex justify-content-between align-items-center">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close flex-end" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <h1 class="h4 text-gray-900 mb-4">New Password</h1>
                        </div>
                        <form class="user" action="{{ route('newPassword.auth') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-user" id="password"
                                    aria-describedby="password" placeholder="Enter new password...">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group text-end pe-3">
                                <button type="submit" class="btn-solid-small">
                                    Update
                                </button>
                            </div>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
