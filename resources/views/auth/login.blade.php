@extends('user.layouts.main')

@section('content')
    <div class="container py-3">
        <div class="card border-0 shadow-lg mt-5 mb-3" style="max-width: 400px; margin: 0 auto;">
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
                            @if (session('success'))
                                <div class="alert alert-success d-flex justify-content-between align-items-center">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close flex-end" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <h1 class="h4 text-gray-900 mb-4">Login</h1>
                        </div>
                        <form class="user" action="{{ route('login.auth') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="login" class="form-control form-control-user" id="login"
                                    aria-describedby="login" placeholder="Enter username or email...">
                                @error('login')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-user"
                                    id="exampleInputPassword" placeholder="Enter password...">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group text-end pe-3">
                                <button type="submit" class="btn-solid-small">
                                    Login
                                </button>
                            </div>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="{{ route('forgotPassword') }}">Forgot Password?</a>
                            |
                            <a class="small" href="{{ route('register') }}">Create an Account!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
