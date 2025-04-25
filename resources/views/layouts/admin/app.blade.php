@include('layouts.admin.partials.header')



<body class="layout-fixed sidebar-expand-lg sidebar-mini bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        <nav class="app-header navbar navbar-expand bg-body">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Start Navbar Links-->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                </ul>
                <!--end::Start Navbar Links-->
                <!--begin::End Navbar Links-->
                <ul class="navbar-nav ms-auto">
                    <!--begin::User Menu Dropdown-->
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <span class="d-none d-md-inline">{{ auth()->user()->fullname }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-md dropdown-menu-end w-50">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-default btn-flat">Sign out</button>
                            </form>
                            <!--end::Menu Footer-->
                        </ul>
                    </li>
                    <!--end::User Menu Dropdown-->
                </ul>
                <!--end::End Navbar Links-->
            </div>
            <!--end::Container-->
        </nav>
        <!--end::Header-->
        <!--begin::Sidebar-->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <!--begin::Sidebar Brand-->
            <div class="sidebar-brand">
                <!--begin::Brand Link-->
                <a href="/admin/dashboard" class="brand-link">
                    <!--begin::Brand Image-->
                    <span class="brand-image opacity-75 shadow fw-bold">MMRC</span>
                    <!--end::Brand Image-->
                    <!--begin::Brand Text-->
                    <span class="brand-text fw-light"> Tailoring</span>
                    <!--end::Brand Text-->
                </a>
                <!--end::Brand Link-->
            </div>
            <!--end::Sidebar Brand-->
            <!--begin::Sidebar Wrapper-->
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <!--begin::Sidebar Menu-->
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                        data-accordion="false">

                        {{-- <li class="nav-item">
                            <a href="../generate/theme.html" class="nav-link">
                                <i class="nav-icon bi bi-palette"></i>
                                <p>Theme Generate</p>
                            </a>
                        </li> --}}

                        <x-admin.list-link link="{{ route('admin.dashboard') }}" active="{{ request()->routeIs('admin.dashboard') }}">
                            <x-slot name="title">Dashboard</x-slot>
                            <x-slot name="icon"><i class="nav-icon bi bi-speedometer"></i></x-slot>
                        </x-admin.list-link>
                        <x-admin.list-link link="{{ route('admin.appointment.index', ['status' => 'all']) }}" active="{{ request()->routeIs('admin.appointment.index') }}" hasCount="true" :count="appointmentPendingCount()">
                            <x-slot name="title">Appointments</x-slot>
                            <x-slot name="icon"><i class="nav-icon bi bi-calendar-check"></i></x-slot>
                        </x-admin.list-link>
                        <x-admin.list-link link="{{ route('admin.order.index', [
                        'status' => 'all']) }}" active="{{ request()->routeIs('admin.order.index') }}" :hasCount="true" :count="orderPendingCount()">
                            <x-slot name="title">Orders</x-slot>
                            <x-slot name="icon"><i class="nav-icon bi bi-bag-check"></i></x-slot>
                        </x-admin.list-link>
                       @if (auth()->user()->role === 'superadmin')
                            <x-admin.list-link link="{{ route('admin.uniform-price.index') }}" active="{{ request()->routeIs('admin.uniform-price.index') }}">
                            <x-slot name="title">Uniform Prices</x-slot>
                            <x-slot name="icon"><i class="nav-icon bi bi-tags"></i></x-slot>
                        </x-admin.list-link>
                            <x-admin.list-link link="{{ route('admin.admin-users.index') }}" active="{{ request()->routeIs('admin.admin-users.index') }}">
                            <x-slot name="title">Admin Users</x-slot>
                            <x-slot name="icon"><i class="nav-icon bi-person-gear"></i></x-slot>
                        </x-admin.list-link>
                        <x-admin.dropdown-list active="{{ request()->routeIs('admin.settings.*') }}">
                            <x-slot name="title">Settings</x-slot>
                            <x-slot name="icon"><i class="nav-icon bi bi-gear"></i></x-slot>
                            <x-admin.list-link link="{{ route('admin.settings.index') }}" active="{{ request()->routeIs('admin.settings.index') }}">
                                <x-slot name="title">Settings</x-slot>
                                <x-slot name="icon"><i class="nav-icon bi bi-calendar2-check"></i></x-slot>
                            </x-admin.list-link>
                            <x-admin.list-link link="{{ route('admin.settings.payment-option') }}" active="{{ request()->routeIs('admin.settings.payment-option') }}">
                                <x-slot name="title">Payment Options</x-slot>
                                <x-slot name="icon"><i class="nav-icon bi bi-credit-card"></i></x-slot>
                            </x-admin.list-link>
                        </x-admin.dropdown-list>
                       @endif
                    </ul>
                    <!--end::Sidebar Menu-->
                </nav>
            </div>
            <!--end::Sidebar Wrapper-->
        </aside>
        <!--end::Sidebar-->
        <!--begin::App Main-->
        <main class="app-main">
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">

                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content Header-->
            <!--begin::App Content-->
            <div class="app-content">
                <!--begin::Container-->
                <div class="container-fluid">
                    @include('sweetalert::alert')
                    @yield('content')
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content-->
        </main>
        <!--end::App Main-->
    </div>
    <!--end::App Wrapper-->
@include('layouts.admin.partials.footer')