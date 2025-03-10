<header class="app-header border-bottom">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <li class="nav-item d-flex align-items-center me-2">
                    <span class="fw-bold">Hi, {{ Auth::user()->name }}</span>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="" width="35"
                            height="35" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                        <div class="message-body">
                            <div class="d-flex align-items-center p-3 border-bottom">
                                <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="Profile Picture" width="40" height="40" class="rounded-circle">
                                <div class="ms-3">
                                    <p class="mb-1 fw-bold">{{ Auth::user()->name }}</p>
                                    <p class="mb-0 text-muted small">{{ Auth::user()->email }}</p>
                                    <p class="mb-0 text-muted small">username: {{ Auth::user()->username }}</p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="btn btn-outline-danger mx-3 mt-2 d-block">Logout</a>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
