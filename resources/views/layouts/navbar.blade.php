<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Brand -->
    <a class="navbar-brand ps-3" href="{{ route('dashboard') }}">
        Cafe POS
    </a>

    <!-- Sidebar Toggle -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0"
            id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Search -->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search..." />
            <button class="btn btn-primary" type="button">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

    <!-- User Dropdown -->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown"
               href="#" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-user fa-fw"></i>
                {{ Auth::user()->name ?? 'User' }}
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <span class="dropdown-item-text">
                        Role: {{ Auth::user()->role }}
                    </span>
                </li>
                <li><hr class="dropdown-divider"></li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
