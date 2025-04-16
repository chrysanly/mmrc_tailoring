<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tailoring - @yield('title', '')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/welcome.css') }}">

    @stack('styles')

</head>

<body class="antialiased">

    <x-layouts.user.partials.header />

    @include('sweetalert::alert')

    @yield('content')


    <!-- Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="orderModalLabel">Choose Order</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-lg-around align-items-center">
                        <a href="{{ route('user.order.index', ['order_type' => 'customized']) }}" type="button"
                            class="btn btn-primary">
                            <i class="bi bi-scissors"></i> Customized
                        </a>
                        <a href="{{ route('user.order.index', ['order_type' => 'ready_made']) }}" type="button"
                            class="btn btn-secondary">
                            <i class="bi bi-box-seam"></i> Ready Made
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('layouts.footer')

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/main.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const orderBtns = document.querySelectorAll('.orderNow');

            orderBtns.forEach(function(orderBtn) {
                orderBtn.onclick = function() {
                    const orderModal = new bootstrap.Modal(document.getElementById('orderModal'));
                    orderModal.show();
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
