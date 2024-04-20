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
                        <h2><span>Awesome websites</span><br> built with tons of love</h2>
                        <p>In gravida vitae nulla vitae tincidunt imperdiet ante. Pellentesque aliquet mi eu tortor dictum,
                            non imperdiet ante viverra. Phasellus eget enim orci flig rine bilo</p>

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
        </div> <!-- end of container -->
    </div> <!-- end of filter -->

    <!-- Invitation -->
    <div class="basic-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-container">
                        <h4>In gravida at nunc sodales pretium. Vivamus semper, odio vitae mattis auctor, elit elit semper
                            magna rico</h4>
                        <p class="p-large">Ac tristique velit sapien vitae eros. Praesent ut erat a tellus cursus pharetra
                            finibus posuere nisi. Vivamus feugiat tincidunt sem pre toro</p>
                    </div> <!-- end of text-container -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of basic-2 -->
    <!-- end of invitation -->


    <!-- Contact -->
    <div id="contact" class="form-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="h2-heading"><span>Use the following form to</span><br> request a quote for your project</h2>
                    <p class="p-heading">Vel malesuada sapien condimentum nec. Fusce interdum nec urna et finibus pulvinar
                        tortor id</p>
                    <ul class="list-unstyled li-space-lg">
                        <li><i class="fas fa-map-marker-alt"></i> &nbsp;22 Praesentum, Pharetra Fin, CB 12345, KL</li>
                        <li><i class="fas fa-phone"></i> &nbsp;<a href="tel:00817202212">+81 720 2212</a></li>
                        <li><i class="fas fa-envelope"></i> &nbsp;<a href="mailto:lorem@ipsum.com">lorem@ipsum.com</a>
                        </li>
                    </ul>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
            <div class="row">
                <div class="col-lg-10 offset-lg-1">

                    <!-- Contact Form -->
                    <form>
                        <div class="form-group">
                            <input type="text" class="form-control-input" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control-input" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <select class="form-control-select" required>
                                <option class="select-option" value="" disabled selected>Project type</option>
                                <option class="select-option" value="Company Website">Company Website</option>
                                <option class="select-option" value="Landing Page">Landing Page</option>
                                <option class="select-option" value="Online Shop">Online Shop</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control-textarea" placeholder="Message" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control-submit-button">Submit</button>
                        </div>
                    </form>
                    <!-- end of contact form -->

                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of form-1 -->
    <!-- end of contact -->
@endsection
