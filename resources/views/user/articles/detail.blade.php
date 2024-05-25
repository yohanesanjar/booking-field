@extends('user.layouts.main')

@section('content')
    <!-- Header -->
    <header class="ex-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1">
                    <h1>{{ $post->title }}</h1>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header> <!-- end of ex-header -->
    <!-- end of header -->

    <!-- Basic -->
    <div class="ex-basic-1 pt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3">
                    <img style="height: 500px; width: 100%" class="img-fluid" src="{{ asset('storage/' . $post->thumbnail) }}"
                        alt="{{ $post->title }}">
                    <div class="text-muted pt-3">
                        <p>{{ $post->category }} by {{ $post->user->name }}</p>
                    </div>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of ex-basic-1 -->
    <!-- end of basic -->

    <!-- Cards -->
    <div class="ex-cards-1 pb-3">
        <div class="container p-3">
            {!! $post->description !!}
        </div> <!-- end of container -->
    </div> <!-- end of ex-cards-1 -->
    <!-- end of cards -->
@endsection