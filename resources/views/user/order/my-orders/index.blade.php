@extends('layouts.user.app')

@section('title', 'Order History')

@section('content')

    <div class="container py-5">

        <h1 class="text-center fw-bold mb-4">Order History</h1>

        <div class="table-container table-responsive">
            <table class="table table-bordered table-striped table-hover rounded shadow-sm rounded-3">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Order Type</th>
                        <th>Payment Type</th>
                        <th>Order Status</th>
                        <th>Order Payment Status</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            <td>{{ $order->order_type }}</td>
                            <td>
                                @if ($order->payments->isEmpty())
                                    Unpaid
                                @endif
                                @if ($order->payments->isNotEmpty())
                                    @if ($order->payments->first()->type === 'downpayment')
                                        Down Payment
                                    @elseif($order->payments->first()->type === 'fullpayment')
                                        Full Payment
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if ($order->status === 'pending')
                                    <div class="badge rounded-pill text-bg-secondary">Pending</div><br>
                                @elseif($order->status === 'in-progress')
                                    <div class="badge rounded-pill text-bg-info">In Progress</div><br>
                                @elseif($order->status === 'done')
                                    <div class="badge rounded-pill text-bg-primary">Done</div><br>
                                @else
                                    <div class="badge rounded-pill text-bg-success">Completed</div><br>
                                @endif
                            </td>
                            <td>
                                @php
                                    $badgeClass = 'text-bg-secondary';
                                    $paymentStatus = 'Pending Payment';

                                    if (!$order->payments->isEmpty()) {
                                        if (
                                            $order->status === 'done' &&
                                            $order->payments->last()->type === 'downpayment'
                                        ) {
                                            $badgeClass = 'text-bg-warning';
                                            $paymentStatus = 'Balance Payment';
                                        } elseif (
                                            $order->payments->last()->type === 'fullpayment' &&
                                            !$order->payments->last()->is_verified
                                        ) {
                                            $badgeClass = 'text-bg-warning';
                                            $paymentStatus = 'Full Payment Verification';
                                        } elseif (
                                            $order->payments->last()->type === 'fullpayment' &&
                                            $order->payments->last()->is_verified
                                        ) {
                                            $badgeClass = 'text-bg-success';
                                            $paymentStatus = 'Paid';
                                        } elseif (
                                            $order->payments->first()->type === 'downpayment' &&
                                            !$order->payments->first()->is_verified
                                        ) {
                                            $badgeClass = 'text-bg-warning';
                                            $paymentStatus = 'Down Payment Verification';
                                        } elseif (
                                            $order->payments->last()->type === 'downpayment' &&
                                            $order->payments->first()->is_verified
                                        ) {
                                            $badgeClass = 'text-bg-info';
                                            $paymentStatus = 'Down Payment Verified';
                                        } elseif (
                                            $order->payments->last()->type === 'balance' &&
                                            !$order->payments->last()->is_verified
                                        ) {
                                            $badgeClass = 'text-bg-warning';
                                            $paymentStatus = 'Balance Payment Verification';
                                        } elseif (
                                            $order->payments->last()->type === 'balance' &&
                                            $order->payments->last()->is_verified
                                        ) {
                                            $badgeClass = 'text-bg-success';
                                            $paymentStatus = 'Paid';
                                        }
                                    }
                                @endphp
                                <div class="badge rounded-pill {{ $badgeClass }}">
                                    {{ $paymentStatus }}
                                </div>
                            </td>
                            <td width="30%">
                                @if (Str::lower($order->payment_status) === 'unpaid')
                                    @if (!$order->payments->isEmpty() && $order->payments->last()->type === 'downpayment' && $order->status === 'pending')
                                        Payment needs to be verified before processing the order.
                                        {{-- @else
                                            <a href="{{ route('user.order.payment', ['form_type' => $order->path ? 'true' : 'false', 'order' => $order]) }}"
                                                class="btn btn-primary mt-4">Continue Payment
                                            </a> --}}
                                    @endif
                                    @if ($order->payments->isEmpty())
                                        Settle the down payment or full payment to proceed with your order.
                                    @endif
                                    @if (!$order->payments->isEmpty() && $order->payments->first()->type === 'fullpayment')
                                        Your payment is currently being verified. We will notify you once it's
                                        approved.
                                    @endif
                                @endif
                                @if (Str::lower($order->payment_status) === 'down payment')
                                    @if ($order->status === 'pending')
                                        Your down payment has been successfully verified. We will start processing
                                        your order shortly.
                                    @endif
                                    @if ($order->status === 'in-progress')
                                        Your order is currently being processed. <br>
                                        We'll notify you once it is completed so you can settle the remaining
                                        balance. <br>
                                        Thank you for your patience!
                                    @endif

                                    @if ($order->status === 'done' && $order->payments->last()->type === 'downpayment')
                                        Please settle the remaining balance of
                                        {{ $order->invoice->total - $order->invoice->total_payment }} to complete your
                                        order. <br>
                                        Tip: To settle the balance, select the "Settle Balance" option from the Action
                                        button.
                                    @endif
                                    @if ($order->payments->last()->type === 'balance' && $order->status === 'done')
                                        Your balance payment is currently being verified. We will notify you once
                                        it's approved so you can complete your order.
                                    @endif
                                @endif
                                @if ($order->status === 'pending' && $order->payment_status === 'payment-settled')
                                    Your full payment has been successfully verified. We will start processing
                                    your order shortly.
                                @endif
                                @if (Str::lower($order->payment_status) === 'payment settled')
                                    @if ($order->status === 'in-progress')
                                        Your order is currently being processed. <br>
                                        We will notify you once your order is ready for pickup. Thank you for
                                        your patience!
                                    @endif
                                    @if ($order->status === 'done' && !$order->payments->isEmpty() && $order->payments->first()->type === 'downpayment')
                                        Your payment has been successfully verified. You will receive a notification once your order is ready for pickup. Thank you for your patience!
                                    @endif
                                    @if ($order->status === 'pick-up' && !$order->payments->isEmpty() && $order->payments->first()->type === 'downpayment')
                                        Your balance payment is verified. you may pick up your order and update the
                                        status to "Mark as Completed" to
                                        finalize your transaction.
                                        Thank you for your cooperation!
                                    @endif
                                    @if ($order->status === 'done' && !$order->payments->isEmpty() && $order->payments->first()->type === 'fullpayment')
                                        Your order is now ready for pick-up. <br>
                                        You will receive a notification once it is available. <br>
                                        Please update the status to 'Mark as Completed' after picking up your order to finalize your transaction. <br>
                                        Thank you for your cooperation!
                                    @endif
                                    @if ($order->status === 'pick-up' && !$order->payments->isEmpty() && $order->payments->first()->type === 'fullpayment')
                                        Your order is marked as done and ready for pickup. <br> Please update the status
                                        to 'Mark as Completed' once the
                                        order has been picked up to finalize your transaction. <br> Thank you for your
                                        cooperation!
                                    @endif
                                @endif
                                @if ($order->status === 'completed')
                                    <span class="badge rounded-pill text-bg-success">Completed</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        @if ($order->payments->isEmpty())
                                            <li>
                                                <a href="{{ route('user.order.payment', ['form_type' => $order->path ? 'true' : 'false', 'order' => $order]) }}"
                                                    class="dropdown-item">Continue Payment
                                                </a>
                                            </li>
                                        @endif
                                        @if ($order->status === 'pick-up' && $order->payment_status === 'Payment Settled')
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('user.order.mark-as-complete', [$order]) }}">Mark
                                                    as Completed</a>
                                            </li>
                                        @endif

                                        @if ($order->status === 'done' && !$order->payments->isEmpty() && $order->payments->last()->type === 'downpayment')
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('user.order.payment', ['form_type' => $order->path ? 'true' : 'false', 'order' => $order]) }}">Settle
                                                    Balance</a>
                                            </li>
                                        @endif
                                        <li><a class="dropdown-item" href="#" onclick="viewPaymentDetails('{{ $order->id }}')">View Payment</a></li>
                                        <li><a class="dropdown-item" href="#"
                                                onclick="viewOrderDetails('{{ $order->id }}')">View Order
                                                Details</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="d-flex justify-content-center align-items-center text-black fw-bold"
                                    style="height: 50vh" role="alert">
                                    You have no orders at the moment.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
        @if ($orders->hasPages())
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

    <!-- Modal -->
    <div class="modal fade" id="viewOrderDetails" tabindex="-1" aria-labelledby="viewOrderDetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewOrderDetailsLabel">View Order Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-lg-evenly gap-3">
                        <div id="top"></div>
                        <div id="bottom"></div>
                        <div id="ready-made"></div>
                        <div id="file_uploads"></div>
                        <div id="other"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Modal -->
    <div class="modal fade" id="paymentDetailsModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="paymentDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="paymentDetailsModalLabel">Payment Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div id="invoice"></div>
                        <div id="paymentDetails"></div>
                    </div>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .table-container {
            position: relative;
            height: 584px;
        }

        .dropdown-menu {
            position: absolute;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/user/js/order_history/order_details.js') }}"></script>
@endpush
