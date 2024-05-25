@extends('user.layouts.main')
@section('content')
    <!-- Header -->
    <header id="header" class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-5">
                    <div class="text-container pt-5">
                        <div class="section-title">Selamat datang di Jaya Abadi Sports</div>
                        <h3 class="title-hero py-3">Nikmati Fasilitas Olahraga yang Seru dan Nyaman</h3>
                        <p class="p-large">Temukan pengalaman olahraga yang tak terlupakan di Jaya Abadi Sports. Jaya Abadi
                            Sports menghadirkan berbagai fasilitas olahraga yang menarik untuk anda</p>
                        <a class="btn-solid-lg" href="{{ route('user.booking') }}">Book now</a>
                    </div> <!-- end of text-container -->
                </div> <!-- end of col -->
                <div class="col-lg-6 col-xl-7">
                    <div class="image-container">
                        <img class="img-fluid" src="{{ asset('userLib2/images/header-illustration.svg') }}"
                            alt="alternative">
                    </div> <!-- end of image-container -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header> <!-- end of header -->
    <!-- end of header -->
    <!-- Details 2 -->
    <div class="counter">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-7 pb-4">
                    <div class="image-container">
                        <img class="img-fluid" src="{{ asset('userLib2/images/details-2.svg') }}" alt="alternative">
                    </div> <!-- end of image-container -->
                </div> <!-- end of col -->
                <div class="col-lg-6 col-xl-5 ps-5 px-5">
                    <div class="text-container">
                        <h2><span>Temukan Kenyamanan Bermain</span><br> di Lapangan Kami</h2>
                        <p>Nikmati fasilitas lapangan yang modern dan nyaman di Jaya Abadi Sports. Kami hadirkan lingkungan
                            bermain yang aman dan menyenangkan untuk Anda.</p>

                        <!-- Counter -->
                        <div class="counter-container">
                            <div class="counter-cell">
                                <div data-purecounter-start="0" data-purecounter-end="{{ $countTransactions }}"
                                    data-purecounter-duration="2" class="purecounter">1</div>
                                <div class="counter-info">Jumlah Transaksi</div>
                            </div> <!-- end of counter-cell -->
                            <div class="counter-cell red">
                                <div data-purecounter-start="0" data-purecounter-end="{{ $countUsers }}"
                                    data-purecounter-duration="2" class="purecounter">1</div>
                                <div class="counter-info">Jumlah Pengguna</div>
                            </div> <!-- end of counter-cell -->
                        </div> <!-- end of counter-container -->
                        <!-- end of counter -->

                    </div> <!-- end of text-container -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of counter -->
    <!-- end of details 2 -->

    <div id="projects" class="filter bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="h2-heading">Latest Article and Information</h2>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
            @if ($posts->isEmpty())
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-container">
                            <h4 class="h4-heading">No post yet <i class="bi bi-emoji-frown"></i></h4>
                        </div> <!-- end of text-container -->
                    </div> <!-- end of col -->
                </div> <!-- end of row -->
            @else
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Filter -->
                        <div class="button-group filters-button-group">
                            <!-- Button untuk filter "All" -->
                            <button class="button is-checked" data-filter="*">All</button>
                            <!-- Button untuk filter masing-masing kategori -->
                            @foreach ($categories as $category)
                                <button class="button" data-filter=".{{ $category }}">{{ $category }}</button>
                            @endforeach
                        </div> <!-- end of button group -->

                        <div class="grid">
                            @foreach ($posts as $post)
                                <div class="element-item {{ $post->category }}">

                                    <a href="@if ($post->category == 'Artikel') {{ route('detailArticle', $post->id) }} @else {{ route('detailInformation', $post->id) }} @endif"
                                        onclick="openModal()">
                                        <img class="img-fluid" style="height: 300px; width: 100%"
                                            src="{{ asset('storage/' . $post->thumbnail) }}" alt="alternative">
                                        <p><strong>{{ $post->title }}</strong> - {!! Str::limit($post->description, 200) !!}</p>
                                    </a>
                                </div>
                            @endforeach
                        </div> <!-- end of grid -->
                        <!-- end of filter -->
                    </div> <!-- end of col -->
                </div> <!-- end of row -->
            @endif
        </div> <!-- end of container -->
    </div> <!-- end of filter -->

    <!-- Invitation -->
    <div class="basic-2 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-container">
                        <h4>Rasakan keseruan bermain di lapangan dengan teman-teman Anda.</h4>
                        <p class="p-large">Segera lakukan pemesanan lapangan dan nikmati pengalaman bermain yang
                            menyenangkan bersama kami.</p>
                    </div> <!-- end of text-container -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of basic-2 -->
    <!-- end of invitation -->
@endsection
