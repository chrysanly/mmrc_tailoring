<x-layouts.user.app title="Success">

    <div class="container" style="height: 70vh">
        <div class="d-flex justify-content-center align-items-center text-black fw-bold" style="height: 50vh">
            <div class="mx-auto">
                <h1>Payment Successful! 🎉</h1>
                <p>Your payment was processed successfully. Thank you!</p>
                <a href="{{ route('user.order.my-orders') }}" class="btn btn-primary">View Order History</a>
            </div>
        </div>

    </div>

</x-layouts.user.app>
