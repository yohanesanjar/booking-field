<aside id="sidebar" class="sidebar-layout">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SportForia</div>
        </a>

        @if (Auth::user()->role->name = 'owner')
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('owner.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Menu Utama
            </div>

            <!-- Nav Item - Lapangan Collapse Menu -->
            <li
                class="nav-item {{ request()->routeIs('owner.fieldIndex') || request()->routeIs('owner.scheduleIndex') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#collapseLapangan" aria-expanded="true" aria-controls="collapseLapangan">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Data Lapangan</span>
                    <i class="bi bi-caret-down-fill"></i>
                </a>
                <div id="collapseLapangan" class="collapse" aria-labelledby="headingLapangan"
                    data-bs-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ request()->routeIs('owner.fieldIndex') ? 'active' : '' }}"
                            href="{{ route('owner.fieldIndex') }}">Lapangan</a>
                        <a class="collapse-item {{ request()->routeIs('owner.scheduleIndex') ? 'active' : '' }}"
                            href="{{ route('owner.scheduleIndex') }}">Jadwal Lapangan</a>
                        <a class="collapse-item {{ request()->routeIs('owner.scheduleActiveIndex') ? 'active' : '' }}"
                            href="{{ route('owner.scheduleActiveIndex') }}">Jadwal Ketersediaan</a>
                    </div>
                </div>
            </li>

            <li class="nav-item {{ request()->routeIs('owner.bookingIndex') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('owner.bookingIndex') }}">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Data Booking</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('owner.transactionIndex') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('owner.transactionIndex') }}">
                    <i class="fas fa-fw fa-file-invoice-dollar"></i>
                    <span>Data Transaksi</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <div class="sidebar-heading">
                Menu Tambahan
            </div>
            <li class="nav-item {{ request()->routeIs('owner.userIndex') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('owner.userIndex') }}">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Data User</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('owner.paymentMethodIndex') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('owner.paymentMethodIndex') }}">
                    <i class="fas fa-fw fa-cash-register"></i>
                    <span>Metode Pembayaran</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('owner.postIndex') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('owner.postIndex') }}">
                    <i class="fas fa-fw fa-upload"></i>
                    <span>Postingan</span>
                </a>
            </li>
        @endif

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
</aside>
