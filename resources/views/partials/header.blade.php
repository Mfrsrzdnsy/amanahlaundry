<div class="header">

    <div class="header-left">
        <a href="{{ route('dashboard') }}" class="logo">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
        </a>
        <a href="{{ route('dashboard') }}" class="logo logo-small">
            <img src="{{ asset('assets/img/logo-small.png') }}" alt="Logo" width="30" height="30">
        </a>
    </div>

    <div class="menu-toggle">
        <a href="javascript:void(0);" id="toggle_btn">
            <i class="fas fa-bars"></i>
        </a>
    </div>

    <div class="top-nav-search">
        <form>
            <input type="text" class="form-control" placeholder="Search here">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>

    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>
    </a>

    <ul class="nav user-menu">

        <!-- PROFILE DROPDOWN -->
        <li class="nav-item dropdown has-arrow new-user-menus">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">

                <span class="user-img">
                    {{-- <img class="rounded-circle" src="{{ asset('assets/img/profiles/default.png') }}" width="31"
                        alt="User Image"> --}}

                    <div class="user-text">
                        <h6>{{ Auth::user()->name }}</h6>
                        <p class="text-muted mb-0">{{ Auth::user()->role ?? 'User' }}</p>
                    </div>
                </span>

            </a>

            <div class="dropdown-menu">
                <div class="user-header">
                    <div class="avatar avatar-sm">
                        {{-- <img src="{{ asset('assets/img/profiles/default.png') }}" alt="User Image"
                            class="avatar-img rounded-circle"> --}}
                    </div>
                    <div class="user-text">
                        <h6>{{ Auth::user()->name }}</h6>
                        <p class="text-muted mb-0">{{ Auth::user()->role ?? 'User' }}</p>
                    </div>
                </div>

                {{-- <a class="dropdown-item" href="{{ route('profile') }}">My Profile</a> --}}

                <!-- LOGOUT (POST METHOD) -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="dropdown-item" type="submit">Logout</button>
                </form>
            </div>
        </li>

    </ul>

</div>
