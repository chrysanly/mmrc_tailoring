<section id="header">
    <div class="container">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="/"
                class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <svg class="bi me-2" width="40" height="32">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                <span class="fs-4 fw-bold">MMRC Tailoring</span>
            </a>

            <ul class="nav nav-pills">
                <li class="nav-item"><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" aria-current="page">Home</a></li>
                <li class="nav-item"><a href="{{ route('user.appointment.index') }}" class="nav-link {{ request()->routeIs('user.appointment.index') ? 'active' : '' }}">Appointment</a></li>
                <li class="nav-item"><a href="#" class="nav-link">My Orders</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Account</a></li>
                @auth
                @if (auth()->user()->role === 'superadmin')
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a></li>
                @endif
                @endauth

                @guest
                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                @endguest
                @auth
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link">Logout</button>
                    </form>
                </li>
                @endauth
            </ul>
        </header>
    </div>
</section>