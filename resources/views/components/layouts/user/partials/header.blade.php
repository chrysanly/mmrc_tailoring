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
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                        aria-current="page">
                        <i class="bi bi-house-door"></i> Home
                    </a>
                </li>

                @auth
                    @if (auth()->user()->role === 'user')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('user.appointment.*') ? 'active' : '' }}"
                                href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-calendar-check"></i> Appointment
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('user.appointment.index') }}"><i
                                            class="bi bi-calendar-plus"></i> Make an Appointment</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.appointment.my-appointment') }}"><i class="bi bi-calendar-check"></i> My
                                        Appointments</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('user.order.*') ? 'active' : '' }}"
                                href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bag"></i> Order
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item orderNow" href="#"><i class="bi bi-bag-plus"></i> Order
                                        Now</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.order.my-orders') }}"><i
                                            class="bi bi-list-check"></i> My Orders</a></li>
                            </ul>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="bi bi-person-circle"></i> Account
                            </a>
                        </li> --}}
                    @endif
                @endauth
                {{-- <li class="nav-item"><a href="{{ route('user.order.my-orders') }}"
                        class="nav-link {{ request()->routeIs('user.order.my-orders') ? 'active' : '' }}">My Orders</a>
                </li> --}}

                @auth
                    @if (auth()->user()->role === 'superadmin' || auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                    @endif
                @endauth

                @auth
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                @endauth
            </ul>
        </header>
    </div>
</section>
