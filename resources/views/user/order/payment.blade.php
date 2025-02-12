@push('styles')
<style>
    #make-order {
        /* background: url("{{ asset('images/user/order.jpg') }}") no-repeat center center/cover; */
        height: 100vh;
    }

    .card-header {
    color: var(--white-color);
    background-color: var(--dark-color);
    }

    .bg-primary{
        background-color: var(--dark-color) !important;
        color: var(--white-color);
    }
</style>
@endpush

<x-layouts.user.app title="Order">

    <section id="make-order">
        <div class="container py-5">
            @if(session('error'))
            <div class="alert alert-danger col-6 mx-auto">{{ session('error') }}</div>
            @enderror
            @if(session('success'))
            <div class="alert alert-success col-6 mx-auto">{{ session('success') }}</div>
            @enderror

            <div class="card col-6 mx-auto mt-5">
                <div class="card-header">Payment</div>
                <div class="card-body">
                    <div class="alert alert-warning"><b>Note</b>: 50% down-payment is strictly required to process your order.</div>
                    
                    <div class="my-4">
                        <h5 class="mb-2">Order Description</h5>
                        @if ($formType === 'false')
                        <h6>School: {{ $order->school }}</h6>
                        <h6>Top: {{ $order->top }}</h6>
                        <h6>Bottom: {{ $order->bottom }}</h6>
                        <h6>Set: {{ $order->set }}</h6>
                        @else
                        <img src="{{ Storage::url($order->path) }}" alt="image" width="100" height="100">
                        @endif
                    </div>
                    <hr>
                    
                    <div>
                        <h5>Payment Methods</h5>
                        <div class="d-flex justify-content-around gap-5">
                            @foreach ($paymentOptions as $paymentOption)
                                <div class="d-flex flex-column">
                                    <h1>{{ $paymentOption->name }}</h1>
                                    <span><b>Account Number:</b> {{ $paymentOption->account_number }}</span>
                                    <span><b>Account Name:</b> {{ $paymentOption->account_name }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <div class="d-flex flex-row bg-primary gap-3 align-items-center py-1 px-2 rounded">
                                <span><b>Sub Total</b>: 500</span>
                                <span><b>Total</b>: 500</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <small class="text-secondary">Please upload your receipt to verify your payment.</small>
                    <div class="my-3">
                        <label for="formFile" class="form-label">Upload Receipt</label>
                        <input class="form-control" type="file" name="file" id="formFile">
                    </div>

                    <button type="submit" class="w-100 btn btn-primary">Send Payment</button>
                </div>
            </div>

        </div>
    </section>

</x-layouts.user.app>