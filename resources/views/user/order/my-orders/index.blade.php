@extends('layouts.user.app')

@section('title', 'Order History')

@section('content')
    <section id="make-appointment">
        <div class="container py-5">
            <h1 class="text-center fw-bold">Order History</h1>
        </div>
    </section>

    <div class="container mb-5">
        <div class="accordion" id="accordionPanelsStayOpenExample">
            @if ($orders->isEmpty())
                <div class="d-flex justify-content-center align-items-center text-black fw-bold" style="height: 50vh"
                    role="alert">
                    You have no orders at the moment.
                </div>
            @else
                @foreach ($orders as $order)
                    <div class="accordion-item mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button bg-dark-mmrc" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapse{{ $order->id }}" aria-expanded="true"
                                aria-controls="panelsStayOpen-collapse{{ $order->id }}">
                                <div class="fs-6">Order Payment Status: <span
                                        class="badge rounded-pill text-bg-{{ $order->payment_status == 'Payment Settled' ? 'success' : 'secondary' }}">
                                        {{ ucwords(Str::replace('-', ' ', $order->payment_status)) }}</span></div>
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapse{{ $order->id }}"
                            class="accordion-collapse collapse @if ($order->id) show @endif">
                            <div class="accordion-body">
                                <div class="d-flex justify-content-lg-between align-items-start">
                                    {{-- Left --}}
                                    <div>

                                        <strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d') }}<br>
                                        @if (Str::lower($order->payment_status) !== 'payment settled')
                                            <div class="badge text-bg-secondary">
                                                <strong>Total Amount:</strong>
                                                ${{ number_format($order->invoice->total, 2) }}<br>
                                            </div><br>
                                            <div class="badge text-bg-warning">
                                                <strong>Balance Amount:</strong>
                                                ${{ number_format($order->invoice->total - $order->invoice->total_payment, 2) }}
                                            </div><br>
                                        @endif
                                        @if (!$order->path)
                                            <strong>Top:</strong> {{ $order->top ?? '-' }}<br>
                                            <strong>Bottom:</strong> {{ $order->bottom ?? '-' }}<br>
                                            <strong>Set:</strong> {{ $order->set ?? '-' }}<br>
                                        @endif
                                    </div>

                                    {{-- Center --}}
                                    @if ($order->path)
                                        <div>
                                            <img src="{{ Storage::url($order->path) }}" alt="image"
                                                class="img-thumbnail" width="150" height="150">
                                        </div>
                                    @endif

                                    {{-- Right --}}
                                    <div class="text-end">
                                        <strong>Payment Type: <span class="fst-italic fw-normal">{{ $order->payments->first()->type === 'downpayment' ? 'Down Payment' : 'Full Payment' }}</span></strong><br>
                                        <strong>Order Status:</strong>
                                        @if ($order->status === 'pending')
                                            <div class="badge rounded-pill text-bg-secondary">Pending</div><br>
                                        @elseif($order->status === 'in-progress')
                                            <div class="badge rounded-pill text-bg-info">In Progress</div><br>
                                        @elseif($order->status === 'done')
                                            <div class="badge rounded-pill text-bg-primary">Done</div><br>
                                        @else
                                            <div class="badge rounded-pill text-bg-success">Completed</div><br>
                                        @endif

                                        <strong>Payment Status:</strong>

                                        @if (Str::lower($order->payment_status) === 'unpaid')
                                            <div class="badge rounded-pill text-bg-secondary">
                                                {{ $order->payment_status }}
                                            </div><br>

                                            @if ($order->payments->isEmpty() && strtolower($order->payment_status) === 'unpaid' && $order->status === 'pending')
                                                <a href="{{ route('user.order.payment', ['form_type' => $order->path ? 'true' : 'false', 'order' => $order]) }}"
                                                    class="btn btn-primary mt-4">Continue Payment
                                                </a>
                                            @endif
                                            @if (!$order->payments->isEmpty() && $order->payments->last()->type === 'downpayment' && $order->status === 'pending')
                                                Payment needs to be verified before processing the order.
                                                {{-- @else
                                            <a href="{{ route('user.order.payment', ['form_type' => $order->path ? 'true' : 'false', 'order' => $order]) }}"
                                                class="btn btn-primary mt-4">Continue Payment
                                            </a> --}}
                                            @endif
                                        @elseif (Str::lower($order->payment_status) === 'down payment')
                                            <span class="badge rounded-pill text-bg-secondary">Down Payment</span><br>
                                            @if ($order->status === 'pending')
                                                Your down payment has been successfully verified. We will start processing
                                                your order shortly.
                                            @endif
                                            @if ($order->status === 'in-progress')
                                                <div class="mt-2">
                                                    Your order is currently being processed. <br>
                                                    We'll notify you once it is completed so you can settle the remaining
                                                    balance. <br>
                                                    Thank you for your patience!
                                                </div>
                                            @endif

                                            @if ($order->status === 'done' && $order->payments->last()->type === 'downpayment')
                                                <a href="{{ route('user.order.payment', ['form_type' => $order->path ? 'true' : 'false', 'order' => $order]) }}"
                                                    class="btn btn-outline-primary mt-4">Settle Balance</a>
                                            @endif

                                            @if ($order->payments->last()->type === 'balance' && $order->status === 'done')
                                                Your balance payment is currently being verified. We will notify you once
                                                it's approved so you can complete your order.
                                            @endif
                                        @elseif (Str::lower($order->payment_status) === 'payment settled')
                                            <span class="badge rounded-pill text-bg-success">Paid</span>
                                            @if ($order->status === 'in-progress')
                                                <div class="mt-2">Your order is currently being processed. <br>
                                                    We will notify you once your order is ready for pickup. Thank you for
                                                    your patience!</div>
                                            @endif
                                            @if ($order->status === 'done' && $order->payments->first()->type === 'downpayment')
                                                <div class="mt-2">
                                                    Your balance payment is verified. you may pick up your order and update the status to "Completed" to finalize your transaction.
                                                    Thank you for your cooperation!
                                                </div>
                                            @endif
                                            @if ($order->status === 'done' && $order->payments->first()->type === 'fullpayment')
                                                <div class="mt-2">
                                                    Your order is marked as done and ready for pickup. <br> Please update the status to 'Completed' once the order has been picked up to finalize your transaction. <br> Thank you for your cooperation!
                                                </div>
                                            @endif
                                            {{-- @elseif (Str::lower($order->payment_status) === 'settlement payment')
                                            <div class="badge rounded-pill text-bg-primary mb-4">
                                                {{ str_replace('-', ' ', $order->payment_status) }}
                                            </div><br>
                                            <a href="{{ route('user.order.payment', ['form_type' => $order->path ? 'true' : 'false', 'order' => $order]) }}"
                                                class="btn btn-outline-primary">Settle Balance</a> --}}
                                        @else
                                            <span class="badge rounded-pill text-bg-success">Completed</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        @if (!$orders->isEmpty())
            <div class="d-flex justify-content-between mt-4">
                @if ($orders->onFirstPage())
                    <span class="btn btn-secondary disabled">Previous</span>
                @else
                    <a href="{{ $orders->previousPageUrl() }}" class="btn btn-primary">Previous</a>
                @endif

                @if ($orders->hasMorePages())
                    <a href="{{ $orders->nextPageUrl() }}" class="btn btn-primary">Next</a>
                @else
                    <span class="btn btn-secondary disabled">Next</span>
                @endif
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        #accordionPanelsStayOpenExample {
            height: 50vh;
        }
    </style>
@endpush

@push('scripts')
@endpush
