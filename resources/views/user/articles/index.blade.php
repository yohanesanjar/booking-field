@extends('user.layouts.main')

@section('content')
    <!-- Header -->
    <header class="ex-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1">
                    <h1>Articles</h1>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header> <!-- end of ex-header -->
    <!-- end of header -->
    {{-- 
    <div class="container py-5">
        <div class="d-flex justify-content-end">
            <form method="GET" action="{{ route('user.search') }}">
                <div class="input-group">
                    <input class="form-control" name="search" placeholder="Search Field Type" aria-label="Search">
                    <button class="btn-solid-small" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div> --}}

    <!-- Blog Start -->
    <div class="container pt-2">
        <div class="row pb-3">
            <div class="card p-3">
                    @foreach ($posts as $post)
                    <div class="row py-3">
                        <div class="col-md-6">
                            <img style="height: 250px; width: 100%" src="{{ asset('storage/' . $post->thumbnail) }}"
                                class="card-img-top" alt="{{ $post->title }}">
                        </div>
                        <div class="col-md-6">
                            <h3 class="card-title">{{ $post->title }}</h3>
                            <p class="card-text">{!! Str::limit($post->description, 400) !!}</p>
                            <p class="card-text"><small class="text-body-secondary">Posted By: {{ $post->user->name }}</small></p>
                            <div class="button text-end pe-5">
                                <a href="{{ route('detailArticle', $post->id) }}" class="btn-solid-small">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="hr">
                        <hr>
                    </div>
                    @endforeach
                </div>
            <div class="col-md-12 mb-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mb-0">
                        {{ $posts->links() }}
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- Blog End -->
@endsection
