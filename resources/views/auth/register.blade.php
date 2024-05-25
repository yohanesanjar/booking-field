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
                            <h1 class="h4 text-gray-900 mb-4">Register Account</h1>
                        </div>
                        <form class="user" action="{{ route('register.auth') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="name" class="form-control form-control-user" id="name"
                                    aria-describedby="name" value="{{ old('name') }}" placeholder="Enter full name...">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" name="username" class="form-control form-control-user" id="username"
                                    aria-describedby="username" value="{{ old('username') }}" placeholder="Enter username...">
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-user" id="email"
                                    aria-describedby="email" value="{{ old('email') }}" placeholder="Enter email...">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="number" name="phone" class="form-control form-control-user" id="phone"
                                    aria-describedby="phone" value="{{ old('phone') }}" placeholder="Enter phone number..." min="0">
                                @error('phone')
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
                                    Register
                                </button>
                            </div>
                        </form>
                        <hr>
                        <div class="form-group text-center">
                            <a class="small" href="{{ route('login') }}">I have an account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
