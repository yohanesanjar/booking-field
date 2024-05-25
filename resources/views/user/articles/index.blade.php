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
    <!-- Blog Start -->
    <div class="container pt-3">
        <div class="row pb-3">
            <div class="col-md-12 text-center">
                @if ($posts->isEmpty())
                    <h3 class="card-title">Article Not Available <i class="bi bi-emoji-frown"></i></h3>
                @else
                    <div class="card p-3">
                        @foreach ($posts as $post)
                            <div class="row py-3">
                                <div class="col-md-6">
                                    <img style="height: 250px; width: 100%" src="{{ asset('storage/' . $post->thumbnail) }}"
                                        class="card-img-top" alt="{{ $post->title }}">
                                </div>
                                <div class="col-md-6 text-start">
                                    <h3 class="card-title">{{ $post->title }}</h3>
                                    <p class="card-text">{!! Str::limit($post->description, 400) !!}</p>
                                    <p class="card-text"><small class="text-body-secondary">Posted By:
                                            {{ $post->user->name }}</small></p>
                                    <div class="button text-end pe-5">
                                        <a href="{{ route('detailArticle', $post->id) }}" class="btn-solid-small">Read
                                            More</a>
                                    </div>
                                </div>
                            </div>
                            <div class="hr">
                                <hr>
                            </div>
                        @endforeach
                        <div class="row justify-content-center py-4">
                            <div class="col-md-12">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center mb-0">
                                        {{ $posts->links() }}
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Blog End -->
@endsection