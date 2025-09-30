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
            <li class="sidebar-item">
                <a href="#rekomendasi" data-bs-toggle="collapse"
                    class="sidebar-link d-flex justify-content-between align-items-center" aria-expanded="false">
                    <span>
                        <i data-feather="check-square" class="align-middle"></i>
                        <span class="align-middle">Rekomendasi</span>
                    </span>
                    <i class="arrow-icon" data-feather="chevron-right"></i>
                </a>
                <ul id="rekomendasi" class="sidebar-dropdown list-unstyled collapse {{ request()->routeIs('rekomendasi.electre-i') || request()->routeIs('rekomendasi.electre-ii') || request()->routeIs('rekomendasi.electre-iii') ? 'show' : '' }}">
                    <li class="sidebar-item {{ request()->routeIs('rekomendasi.electre-i') ? 'active' : '' }}">
                        <a href="{{ route('rekomendasi.electre-i') }}" class="sidebar-link">
                            <i class="align-middle ms-2">-</i> ELECTRE I
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('rekomendasi.electre-ii') ? 'active' : '' }}">
                        <a href="{{ route('rekomendasi.electre-ii') }}" class="sidebar-link">
                            <i class="align-middle ms-2">-</i> ELECTRE II
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('rekomendasi.electre-iii') ? 'active' : '' }}">
                        <a href="{{ route('rekomendasi.electre-iii') }}" class="sidebar-link">
                            <i class="align-middle ms-2">-</i> ELECTRE III
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="sidebar-cta text-center">
            <div class="sidebar-cta-content">
                <img class="img-fluid mb-2 rounded shadow" src="{{ asset('src/img/logo-no-bg.png') }}" alt="Logo"
                    style="width: 120px; height: auto; object-fit: cover; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
                <strong class="d-inline-block fs-4">Kota Malang</strong>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Inisialisasi Feather Icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        // Fungsi untuk update ikon panah
        function updateArrowIcons() {
            document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(toggle => {
                const targetId = toggle.getAttribute('href') || toggle.getAttribute('data-bs-target');
                const target = document.querySelector(targetId);
                const icon = toggle.querySelector('.arrow-icon');
                
                if (target && icon) {
                    const isExpanded = toggle.getAttribute('aria-expanded') === 'true' || 
                                      target.classList.contains('show');
                    
                    icon.setAttribute('data-feather', isExpanded ? 'chevron-down' : 'chevron-right');
                }
            });
            feather.replace();
        }

        // Update ikon saat awal load
        updateArrowIcons();

        // Gunakan event Bootstrap untuk handle perubahan collapse
        document.querySelectorAll('.collapse').forEach(collapse => {
            collapse.addEventListener('shown.bs.collapse', function() {
                updateArrowIcons();
            });
            
            collapse.addEventListener('hidden.bs.collapse', function() {
                updateArrowIcons();
            });
        });
    });
</script>
