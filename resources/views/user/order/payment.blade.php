@push('styles')
    <style>
        #make-order {
            height: 100vh;
            background: #f8f9fa;
        }

        .card-header {
            color: #fff;
            background-color: #343a40;
        }

        .bg-primary {
            background-color: #343a40 !important;
            color: #fff;
        }

        .alert-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .alert-danger,
        .alert-success {
            color: #fff;
        }

        .alert-danger {
            background-color: #dc3545;
        }

        .alert-success {
            background-color: #28a745;
        }

        .payment-method {
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 1rem;
            text-align: center;
        }

        .payment-method h1 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .payment-method span {
            display: block;
            margin-bottom: 0.25rem;
        }

        .order-description h6 {
            margin-bottom: 0.5rem;
        }

        .order-summary {
            background-color: #343a40;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
        }

        .order-summary span {
            margin-right: 1rem;
        }

        .upload-receipt {
            margin-top: 1rem;
        }

        .upload-receipt label {
            font-weight: bold;
        }

        .upload-receipt input {
            margin-top: 0.5rem;
        }
    </style>
@endpush

<x-layouts.user.app title="Order">

    <section class="container mb-5">
        <div class="d-flex justify-content-around align-items-start gap-3">
            <div class="card col-8">
                <div class="card-header">Payment Description</div>
                <div class="card-body">
                    @if ($order->status === 'pending')
                        <div class="alert alert-warning"><b>Note</b>: {{ $downpayment }}% down payment is strictly
                            required to process
                            your
                            order.
                        </div>
                    @endif

                    <div class="order-description my-4 p-3 border rounded">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-3 text-primary">Order Description</h5>
                                @if (count($order->file_url) < 0)
                                    <div class="text-start">
                                        <h6><b>Order Type:</b> {{ $order->order_type }}</h6>
                                        <h6><b>School:</b> {{ $order->school }}</h6>
                                        <h6><b>Top:</b> {{ $order->top }}</h6>
                                        @isset($order->bottom)
                                            <h6><b>Bottom:</b> {{ $order->bottom }}</h6>
                                        @endisset
                                        <h6><b>Set:</b> {{ $order->set }}</h6>
                                        <h5 class="text-primary mt-4">Additional Items</h5>
                                        <h6><b>Threads:</b> {{ $order->additionalItems->threads ?? 0 }}</h6>
                                        <h6><b>Zipper:</b> {{ $order->additionalItems->zipper ?? 0 }}</h6>
                                        <h6><b>School Seal:</b> {{ $order->additionalItems->school_seal ?? 0 }}</h6>
                                        <h6><b>Buttons:</b> {{ $order->additionalItems->buttons ?? 0 }}</h6>
                                        <h6><b>Hook and Eye:</b> {{ $order->additionalItems->hook_and_eye ?? 0 }}</h6>
                                        <h6><b>Tela:</b> {{ $order->additionalItems->tela ?? 0 }}</h6>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-evenly gap-3">
                                        <div class="text-start">
                                            <h6><b>Order Type:</b> {{ $order->order_type }}</h6>
                                            <h6><b>School:</b> {{ $order->school }}</h6>
                                            <h6><b>Top:</b> {{ $order->top }}</h6>
                                            @isset($order->bottom)
                                                <h6><b>Bottom:</b> {{ $order->bottom }}</h6>
                                            @endisset
                                            <h6><b>Set:</b> {{ $order->set }}</h6>
                                            <h5 class="text-primary mt-4">Additional Items</h5>
                                            <h6><b>Threads:</b> {{ $order->additionalItems->threads ?? 0 }}</h6>
                                            <h6><b>Zipper:</b> {{ $order->additionalItems->zipper ?? 0 }}</h6>
                                            <h6><b>School Seal:</b> {{ $order->additionalItems->school_seal ?? 0 }}
                                            </h6>
                                            <h6><b>Buttons:</b> {{ $order->additionalItems->buttons ?? 0 }}</h6>
                                            <h6><b>Hook and Eye:</b> {{ $order->additionalItems->hook_and_eye ?? 0 }}
                                            </h6>
                                            <h6><b>Tela:</b> {{ $order->additionalItems->tela ?? 0 }}</h6>
                                        </div>
                                        <div class="text-center">
                                            <div class="d-flex flex-column">
                                                @foreach ($order->file_url as $file)
                                                    <a href="{{ $file }}" target="_blank">
                                                        <img src="{{ $file }}" alt="Order Image"
                                                            class="img-thumbnail" width="150" height="150">
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-end">
                                <div class="order-summary d-flex flex-column gap-3 align-items-end py-1 px-2 rounded">

                                    <span><b>Top</b>:
                                        ₱{{ number_format($order->invoice->top_price ?? 0, 2) }}</span>
                                    <span><b>Bottom</b>:
                                        ₱{{ number_format($order->invoice->bottom_price ?? 0, 2) }}</span>
                                    <span><b>Set</b>:
                                        ₱{{ number_format($order->invoice->set_price ?? 0, 2) }}</span>
                                    <span><b>Additional Items</b>:
                                        ₱{{ number_format($order->invoice->additional_price ?? 0, 2) }}</span>
                                    @if ($order->invoice->discount)
                                        <span><b>Discount</b>:
                                            {{ number_format($order->invoice->discount ?? 0, 2) }}%</span>
                                    @endif

                                    <span><b>Sub Total</b>:
                                        ₱{{ number_format($order->invoice->total ?? 0, 2) }}</span>
                                    <span><b>Total Paid</b>:
                                        ₱{{ number_format($order->invoice->total_payment ?? 0, 2) }}</span>
                                    <span><b>Total</b>:
                                        ₱{{ number_format(max(($order->invoice->total ?? 0) - ($order->invoice->total_payment ?? 0), 0), 2) }}</span>

                                    @if (Str::lower($order->payment_status) === 'unpaid' || Str::lower($order->payment_status) === 'down-payment')
                                        <div class="border text-center my-0 p-0" style="width: 100%"></div>
                                    @endif
                                    <div class="align-self-center">
                                        @if (Str::lower($order->payment_status) === 'unpaid')
                                            <div class="text-warning"><b>Down Payment</b>:
                                                ₱{{ number_format($order->invoice->total * ($downpayment / 100) ?? 0, 2) }}
                                            </div>
                                        @endif
                                        @if (Str::lower($order->payment_status) === 'down payment')
                                            <div class="text-warning"><b>Balance</b>:
                                                ₱{{ number_format($order->invoice->total / 2 ?? 0, 2) }}</div>
                                        @endif
                                        @if (Str::lower($order->payment_status) === 'settlement payment')
                                            <div class="text-warning"><b>Balance</b>:
                                                ₱{{ number_format($order->invoice->total - $order->invoice->total_payment ?? 0, 2) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div>
                        <h5>Payment Methods</h5>
                        <div class="d-flex justify-content-around gap-5 mb-3">
                            @foreach ($paymentOptions as $paymentOption)
                                <div class="payment-method">
                                    <h1>{{ $paymentOption->name }}</h1>
                                    <span><b>Account Number:</b> {{ $paymentOption->account_number }}</span>
                                    <span><b>Account Name:</b> {{ $paymentOption->account_name }}</span>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
            @if (!$order->invoice->is_paid)
                <div class="card col-4">
                    <div class="card-header">Payment Form</div>
                    <div class="card-body">
                        @if (
                            $order->payments->isEmpty() ||
                                ($order->payments->last()?->type !== 'balance' && $order->payments->last()?->type !== 'fullpayment'))
                            <form action="{{ route('user.order.store-payment', $order) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <x-user.select name="type" title="Amount to Pay" :col="12">

                                    @if ($order->payments->isEmpty() || $order->payments->last()->type !== 'downpayment')
                                        <option value="downpayment"
                                            {{ old('type') == 'downpayment' ? 'selected' : '' }}>Down
                                            Payment</option>
                                        <option value="fullpayment"
                                            {{ old('type') == 'fullpayment' ? 'selected' : '' }}>Full
                                            Payment</option>
                                    @else
                                        <option value="balance" {{ old('type') == 'balance' ? 'selected' : '' }}>
                                            Balance Payment</option>
                                    @endif
                                </x-user.select>
                                <x-admin.input-field name="contact_number" type="text" label="Contact Number" />
                                <x-admin.input-field name="referrence_number" type="text"
                                    label="Referrence Number" />
                                <x-admin.input-field name="account_name" type="text" label="Account Name" />

                                <small class="text-secondary">Please upload your receipt to verify your payment.</small>
                                <x-admin.input-field name="file" type="file" label="Upload Receipt" />

                                <button type="submit" class="w-100 btn btn-primary">Send Payment</button>
                            </form>
                        @else
                            @if ($order->status === 'completed')
                                Your order has been completed.
                            @elseif ($order->payments->isEmpty() || ($order->status === 'pending' && $order->payments->last()->type === 'full'))
                                payment needs to be verified before processing the order. Please wait for the order to
                                be completed.
                            @else
                                Your balance payment is being verified. Please wait for the admin to process it.
                            @endif
                        @endif

                    </div>
                </div>
            @endif

        </div>
    </section>

</x-layouts.user.app>
