@push('styles')
    <style>
        #make-order {
        /* background: url("{{ asset('images/user/order.jpg') }}") no-repeat center center/cover; */
        height: 100vh;
        }
    </style>
@endpush

<x-layouts.user.app title="Order">

    <section id="make-order">
        <div class="container py-5">
            <h1 class="text-center fw-bold">Make an Order</h1>

            @if(session('error'))
            <div class="alert alert-danger col-6 mx-auto">{{ session('error') }}</div>
            @enderror
            @if(session('success'))
            <div class="alert alert-success col-6 mx-auto">{{ session('success') }}</div>
            @enderror

        </div>
    </section>

</x-layouts.user.app>