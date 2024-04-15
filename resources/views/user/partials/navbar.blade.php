<aside id="navbar" class="navbar-layout">
    <!-- Navigation -->
    <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
        <div class="container">

            <!-- Image Logo -->
            <a class="navbar-brand logo-image" href="{{ route('index') }}"><img
                    src="{{ asset('userLib2/images/logo.svg') }}" alt="alternative"></a>

            <!-- Text Logo - Use this if you don't have a graphic logo -->
            <!-- <a class="navbar-brand logo-text" href="index.html">Zinc</a> -->

            <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav ms-auto navbar-nav-scroll">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('index') || request()->routeIs('user.index') ? 'active' : '' }}"
                            aria-current="page" href="{{ route('index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.booking') ? 'active' : '' }}" href="{{ route('user.booking') }}">Booking</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('getArticle') || request()->routeIs('getInformation') ? 'active' : '' }}" href="#" role="button" id="dropdown01" data-bs-toggle="dropdown"
                            aria-expanded="false">Pages</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown01">
                            <li>
                                <a class="dropdown-item" href="{{ route('getArticle') }}">Article</a></li>
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('getInformation') }}">Information</a></li>
                            <li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#projects">About Us</a>
                    </li>
                    @if (Auth::check())
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span
                                    class="me-2 d-none d-lg-inline text-gray-600">{{ Auth::user()->username }}</span>
                                {{-- <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}" style="height: 2rem; width: 2rem;"
                                alt="Profile Picture"> --}}
                            </a>
                            <!-- Dropdown - User Information -->
                            <ul class="dropdown-menu dropdown-menu-end shadow animated--grow-in"
                                aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">
                                        <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>
                                        Profile
                                    </a></li>
                                <li><a class="dropdown-item" href="{{ route('user.transactionHistory') }}">
                                        <i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>
                                        Transaction History
                                    </a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item" type="submit">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>
                                            Logout
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
                @if (!Auth::check())
                    <span class="nav-item">
                        <a class="btn-solid-sm" href="{{ route('login') }}">Get Started</a>
                    </span>
                @endif
            </div> <!-- end of navbar-collapse -->
        </div> <!-- end of container -->
    </nav> <!-- end of navbar -->
    <!-- end of navigation -->
</aside>
