<aside class="left-sidebar">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-center position-relative">
            <a href="#" class="text-nowrap mt-5 mb-2">
                <img src="{{ asset('assets/images/Logo.png') }}" width="120" alt="" />
            </a>
            <div class="close-btn position-absolute top-0 end-0 mt-2 me-2 d-xl-none d-block sidebartoggler cursor-pointer"
                id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-home"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Pages</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('kriteria.index') ? 'active' : '' }}" href="{{ route('kriteria.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-list"></i>
                        </span>
                        <span class="hide-menu">Data Kriteria</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('wilayah.index') ? 'active' : '' }}" href="{{ route('wilayah.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-map"></i>
                        </span>
                        <span class="hide-menu">Data Wilayah</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <span>
                            <i class="ti ti-school"></i>
                        </span>
                        <span class="hide-menu">Data Sekolah</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <span>
                            <i class="ti ti-list-check"></i>
                        </span>
                        <span class="hide-menu">Lihat Rekomendasi</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>