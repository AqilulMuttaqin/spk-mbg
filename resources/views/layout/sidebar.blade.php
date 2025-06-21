<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">MBGMalang</span>
        </a>
        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Home
            </li>
            <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('dashboard') }}">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-header">
                Pages
            </li>
            <li class="sidebar-item {{ request()->routeIs('kriteria.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('kriteria.index') }}">
                    <i class="align-middle" data-feather="list"></i>
                    <span class="align-middle">Kriteria</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('wilayah.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('wilayah.index') }}">
                    <i class="align-middle" data-feather="map-pin"></i>
                    <span class="align-middle">Wilayah</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('sekolah.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('sekolah.index') }}">
                    <i class="align-middle" data-feather="home"></i>
                    <span class="align-middle">Sekolah</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('rekomendasi.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('rekomendasi.index') }}">
                    <i class="align-middle" data-feather="check-square"></i>
                    <span class="align-middle">Rekomendasi</span>
                </a>
            </li>
        </ul>
        <div class="sidebar-cta text-center">
            <div class="sidebar-cta-content">
                <img class="img-fluid mb-2 rounded shadow" src="{{ asset('src/img/logo-no-bg.png') }}" alt="Logo" style="width: 120px; height: auto; object-fit: cover; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
                <strong class="d-inline-block fs-4">Kota Malang</strong>
            </div>
        </div>
    </div>
</nav>