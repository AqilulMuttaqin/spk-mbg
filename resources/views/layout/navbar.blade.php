<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>
    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>
                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <img src="{{ asset('src/img/avatars/avatar.jpg') }}" class="avatar img-fluid rounded me-1" alt="Profile" />
                    <span class="text-dark">{{  Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="message-body">
                        <div class="d-flex align-items-center p-3 border-bottom">
                            <img src="{{ asset('src/img/avatars/avatar.jpg') }}" alt="Profile Picture" width="40" height="40" class="rounded-circle">
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