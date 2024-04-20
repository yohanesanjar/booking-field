@extends('admin.layouts.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Postingan</h1>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">{{ $post->title }}</h2>
                    <a href="{{ route('admin.postIndex') }}" class="btn btn-success btn-sm"><i
                            class="bi bi-arrow-left-circle"></i> Back</a>
                    <a href="{{ route('admin.postEdit', $post->id) }}" class="btn btn-warning btn-sm"><i
                            class="fa fa-edit"></i> Edit</a>
                    <div class="thumbnail py-3">
                        <img class="img-fluid" style="height: 400px; width: 100%"
                            src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}">
                    </div>
                    <div class="info text-muted pt-3">
                        <p>{{ $post->category }} by {{ $post->user->name }}</p>
                    </div>
                    <div class="card-text py-2">
                        {!! $post->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
