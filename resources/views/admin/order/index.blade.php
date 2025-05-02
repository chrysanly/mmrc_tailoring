@extends('layouts.admin.app')

@section('title', 'Orders')

@push('styles')
    <style>
        :root {
            --dark-color: #1d1616;
            --red-color: #8e1616;
            --light-red-color: #d84040;
            --white-color: #eeeeee;
        }

        h1 {
            color: var(--light-red-color);
        }

        .modal-title {
            color: var(--dark-color) !important;
            font-weight: bolder !important;
        }

        #top,
        #bottom,
        #other,
        #ready-made. #file_uploads {
            border: 1px solid var(--white-color);
            padding: 20px;
            border-radius: 15px;
            box-shadow: -1px 8px 15px -2px rgba(3, 3, 3, 0.38);
            -webkit-box-shadow: -1px 8px 15px -2px rgba(3, 3, 3, 0.38);
            -moz-box-shadow: -1px 8px 15px -2px rgba(3, 3, 3, 0.38);
            margin-bottom: 30px;
        }

        h1.measurement-title {
            border-bottom: 1px solid;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/admin/js/order.js') }}"></script>
    <script src="{{ asset('assets/admin/js/order/settle-balance.js') }}"></script>
    <script src="{{ asset('assets/admin/js/order/view.js') }}"></script>
    <script src="{{ asset('assets/admin/js/order/print.js') }}"></script>
@endpush

@section('content')
    @php
        $tabs = [
            [
                'id' => 'all',
                'name' => 'All',
                'route' => route('admin.order.index', [
                    'status' => 'all',
                ]),
            ],
            [
                'id' => 'pending',
                'name' => 'Pending',
                'route' => route('admin.order.index', [
                    'status' => 'pending',
                ]),
            ],
            [
                'id' => 'in-progress',
                'name' => 'In Progress',
                'route' => route('admin.order.index', [
                    'status' => 'in-progress',
                ]),
            ],
            [
                'id' => 'done',
                'name' => 'Done',
                'route' => route('admin.order.index', [
                    'status' => 'done',
                ]),
            ],
            [
                'id' => 'pick-up',
                'name' => 'Pick Up',
                'route' => route('admin.order.index', [
                    'status' => 'pick-up',
                ]),
            ],
            [
                'id' => 'completed',
                'name' => 'Completed',
                'route' => route('admin.order.index', [
                    'status' => 'completed',
                ]),
            ],
        ];
    @endphp
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        @foreach ($tabs as $item)
            <li class="nav-item" role="presentation">
                <a href="{{ $item['route'] }}" class="nav-link {{ request('status') === $item['id'] ? 'active' : '' }}"
                    id="{{ $item['id'] }}-tab" type="button" role="tab" aria-controls="{{ $item['id'] }}-tab-pane"
                    aria-selected="{{ $item['id'] === 'pending' ? 'true' : 'false' }}">{{ $item['name'] }}</a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content" id="myTabContent">
        @foreach ($tabs as $item)
            <div class="tab-pane fade {{ $item['id'] === request('status') ? 'show active' : '' }}"
                id="{{ $item['id'] }}-tab-pane" role="tabpanel" aria-labelledby="{{ $item['id'] }}-tab" tabindex="0">
                <div class="col-md-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Orders</h3>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Order Type</th>
                                        <th>Payment Status</th>
                                        <th>Top</th>
                                        <th>Bottom</th>
                                        <th>Status</th>
                                        @if (request('status') === 'completed' || request('status') === 'all')
                                            <th>Date Completed</th>
                                        @endif
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->user->fullname }}</td>
                                            <td>{{ $order->order_type }}</td>
                                            <td>{{ $order->payment_status }}</td>
                                            <td>{{ $order->top }}</td>
                                            <td>{{ $order->bottom }}</td>
                                            <td class="text-center">
                                                @if ($order->status === 'pending')
                                                    <span class="badge rounded-pill text-bg-secondary">Pending</span>
                                                @elseif ($order->status === 'in-progress')
                                                    <span class="badge rounded-pill text-bg-info">In Progress</span>
                                                @elseif ($order->status === 'done')
                                                    <span class="badge rounded-pill text-bg-primary">Done</span>
                                                @elseif ($order->status === 'pick-up')
                                                    <span class="badge rounded-pill text-bg-warning">Pick Up</span>
                                                @else
                                                    <span class="badge rounded-pill text-bg-success">Completed</span>
                                                @endif
                                            </td>
                                            @if (request(key: 'status') === 'completed' || request(key: 'status') === 'all')
                                                <th>{{ $order->completed_at ?? '-' }}</th>
                                            @endif
                                            <td width="2%">
                                                <div class="dropdown">
                                                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @if (
                                                            (Str::lower($order->payment_status) === 'down payment' && $order->status === 'pending') ||
                                                                (Str::lower($order->payment_status) === 'payment settled' && $order->status === 'pending'))
                                                            <x-admin.order-update-status :id="$order->id"
                                                                icon="bi-arrow-right-circle" status="in-progress"
                                                                button="Move to In Progress" />
                                                        @endif

                                                        @if ($order->status === 'in-progress' && Str::lower($order->payment_status) === 'payment settled')
                                                            <x-admin.order-update-status :id="$order->id"
                                                                icon="bi-arrow-right-circle" status="done"
                                                                button="Move to Done" />
                                                        @endif
                                                        @if ($order->status === 'in-progress' && Str::lower($order->payment_status) === 'down payment')
                                                            <x-admin.order-update-status :id="$order->id"
                                                                icon="bi-arrow-right-circle" status="done"
                                                                button="Move to Done" />
                                                        @endif

                                                        @if (
                                                                $order->status === 'done' &&
                                                                Str::lower($order->payment_status) === 'payment settled' &&
                                                                !$order->payments->isEmpty() &&
                                                                in_array($order->payments->last()->type, ['fullpayment', 'balance']) // Allow both payment types
                                                            )
                                                            <x-admin.order-update-status :id="$order->id" icon="bi-truck"
                                                                status="pick-up" button="Move to Pick Up" />
                                                        @endif
                                                        @if (
                                                            $order->status === 'pick-up' &&
                                                                Str::lower($order->payment_status) === 'payment settled' &&
                                                                !$order->payments->isEmpty() &&
                                                                $order->payments->last()->type === 'fullpayment')
                                                            <x-admin.order-update-status :id="$order->id" icon="bi-bell"
                                                                status="completed" button="Send Reminder" />
                                                        @endif

                                                        <li>
                                                            <button type="button" class="dropdown-item"
                                                                onclick="viewOrder({{ $order->id }})">
                                                                <i class="bi bi-card-list"></i> Order Details
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button type="button" class="dropdown-item"
                                                                onclick="viewPaymentDetails({{ $order->id }})">
                                                                <i class="bi bi-credit-card"></i> Payment Details
                                                            </button>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        @endforeach
    </div>

    <!-- /.row -->

    <!-- Modal -->
    <div class="modal fade" id="viewOrderModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="viewOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewOrderModalLabel">Order Details</h1>
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
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
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

    <!-- Modal -->
    <div class="modal fade" id="addDiscountModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="addDiscountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addDiscountModalLabel">Add Discount</h1>
                </div>
                <div class="modal-body">
                    <x-admin.input-field name="discount" type="number" label="Discount (%)" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="discountBackButton"
                        data-bs-dismiss="modal">Back</button>
                    <button type="button" class="btn btn-primary" id="discountSaveButton">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="settleBalanceModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="settleBalanceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="settleBalanceModalLabel">Settle Balance</h1>
                </div>
                <div class="modal-body">
                    <x-admin.input-field name="contact_number" type="number" label="Contact Number" />
                    <x-admin.input-field name="ref_number" type="number" label="Referrence Number" />
                    <x-admin.input-field name="account_name" type="text" label="Account Name" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="settleBalanceCancelBtn"
                        data-bs-dismiss="modal">Back</button>
                    <button type="button" class="btn btn-primary" id="settleBalanceSaveBtn">Settle Balance</button>
                </div>
            </div>
        </div>
    </div>

@endsection
