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
    <script>
        const orderModal = document.getElementById('viewOrderModal');
        const paymentDetailsModal = document.getElementById('paymentDetailsModal');
        const modalTop = document.querySelector('#viewOrderModal #top');
        const modalBottom = document.querySelector('#viewOrderModal #bottom');
        const modalOther = document.querySelector('#viewOrderModal #other');
        const modalReadyMade = document.querySelector('#viewOrderModal #ready-made');
        const modalFiles = document.querySelector('#viewOrderModal #file_uploads');

        const paymentInvoice = document.querySelector('#paymentDetailsModal #invoice');
        const paymentDetails = document.querySelector('#paymentDetailsModal #paymentDetails');

        let paymentDetailsData = [];
        let invoiceId;
        let paymentId;
        let discount;
        function viewOrder(id) {
            $('#viewOrderModal').modal('show');
            fetchOrder(id);
        }

        function viewPaymentDetails(id) {
            paymentId = id;
            $('#paymentDetailsModal').modal('show');
            fetchPaymentDetails(id);
        }

        function addDiscount(id) {
            $("#discount").val(discount);
            invoiceId = id;
            $('#addDiscountModal').modal('show');
            $('#paymentDetailsModal').modal('hide');
        }

        $("#discountSaveButton").on('click', function (e){
            e.preventDefault();
            console.log('clicked');
            
            $("#discountSaveButton").addClass('disabled');

            const formData = new FormData();
            formData.append('discount', $("#discount").val());
            formData.append("_method", "PATCH");

            ajaxPostRequest('/admin/order/api/invoice/discount/' + invoiceId, formData)
            .then(response => {
                if (response.error) {
                    swalMessage("", `${response.error}`, "success");
                    return;
                } else {
                    swalMessage("", "Discount Added Successfully", "success");
                    fetchPaymentDetails(paymentId);
                    $('#addDiscountModal').modal('hide');
                    $('#paymentDetailsModal').modal('show');
                    $("#discountSaveButton").removeClass('disabled');
                }
            })
            .catch(error => {
                console.log(error);
                $("#discountSaveButton").removeClass('disabled');
                
            })
        });

        $("#discountBackButton").on('click', function () {
             $('#addDiscountModal').modal('hide');
            $('#paymentDetailsModal').modal('show');
        });


        function fetchOrder(id) {
            ajaxGetRequest(`order/api/view/${id}`)
                .then(response => {
                    const data = response.data;
                    const orderType = data.order_type;


                    modalTop.innerHTML = ``;
                    modalBottom.innerHTML = ``;
                    modalOther.innerHTML = ``;
                    modalFiles.innerHTML = ``;
                    modalReadyMade.innerHTML = ``;
                    if (orderType === 'Customized') {
                        console.log(data);

                        modalReadyMade.classList.add("d-none");
                        modalTop.classList.remove('d-none');
                        modalBottom.classList.remove('d-none');
                        modalOther.classList.remove('d-none');

                        const top = data.top;
                        const bottom = data.bottom;
                        const topMeasurable = data.top_measurement?.measurable;
                        const bottomMeasurable = data.bottom_measurement?.measurable;


                        console.log(data.file_url.length > 1);

                        if (data.file_url.length >= 1) {
                            modalTop.classList.add('d-none');
                            modalBottom.classList.add('d-none');
                            modalFiles.classList.remove('d-none');
                            modalFiles.classList.add("w-50", "text-center", "text-body-emphasis");

                            appendUploadedFiles(data);

                        } else {
                            modalTop.classList.remove('d-none');
                            modalBottom.classList.remove('d-none');
                            if (top) {
                                appendOrderTopDetails(topMeasurable, top);
                            } else {
                                modalTop.innerHTML = `
                            <h1>Top Measurement</h1>
                            <p class="text-wrap w-75 text-warning-emphasis">No top measurement data available for this order.</p>
                            `;
                            }

                            if (bottom) {
                                appendOrderBottomDetails(bottomMeasurable, bottom);
                            } else {
                                modalBottom.innerHTML = `
                            <h1>Bottom Measurement</h1>
                            <p class="text-wrap w-75 text-warning-emphasis">No bottom measurement data available for this order.</p>
                            `;
                            }
                        }
                        appendOrderOtherDetails(data);


                    } else {
                        modalTop.classList.add('d-none');
                        modalBottom.classList.add('d-none');
                        modalOther.classList.add('d-none');
                        modalFiles.classList.add('d-none');
                        modalReadyMade.classList.remove("d-none");

                        modalReadyMade.classList.add("w-100", "text-center", "text-body-emphasis");

                        appendOrderReadyMadeDetails(data);
                    }


                })
                .catch(error => {
                    console.error('Error fetching order:', error);
                    swalMessage("Unable to load order data");
                });
        }

        function fetchPaymentDetails(id) {
            ajaxGetRequest(`order/api/view/${id}`)
                .then(response => {
                    
                    const data = response.data;
                    const invoice = data.invoice;
                    const payments = data.payments;
                    console.log(!invoice.is_paid );
                    console.log(data.status === 'pending');
                    
                    discount = invoice.discount;
                    paymentInvoice.innerHTML = `
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="card-title">Invoice</div>
                          ${!invoice.is_paid && data.status === 'pending' ? `
    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addDiscount('${invoice.id}')">
        ${invoice.discount === null ? 'Add' : 'Update'} Discount (%)
    </button>
` : `
    <span class="badge text-bg-success">Paid</span>
`}
                                    
                            </div>
                        </div> 
                        <div class="card-body">
                            <div class="d-flex justify-content-evenly align-items-center">
                                <div class="row">
                                    <span class="fw-bold">Bottom Price: </span>
                                    <span>${invoice.bottom_price}</span>
                                </div>
                                <div class="row">
                                    <span class="fw-bold">Top Price: </span>
                                    <span>${invoice.top_price}</span>
                                </div>
                                <div class="row">
                                    <span class="fw-bold">Set Price: </span>
                                    <span>${invoice.set_price}</span>
                                </div>
                                <div class="row">
                                    <span class="fw-bold">Additonal Price: </span>
                                    <span>${invoice.additional_price}</span>
                                </div>
                                <div class="row">
                                    <span class="fw-bold">Discount: </span>
                                    <span>${invoice.discount ?? 0.0}%</span>
                                </div>
                                <div class="row">
                                    <span class="fw-bold">Total: </span>
                                    <span>${invoice.total}</span>
                                </div>
                                <div class="row">
                                    <span class="fw-bold">Total Payment: </span>
                                    <span>${invoice.total_payment ?? 0.00}</span>
                                </div>
                            </div>
                        </div>   
                    </div>
                    `;

                    paymentDetails.innerHTML = `
                    <div class="card mt-2">
                        <div class="card-header">
                            <div class="card-title">Payment Details</div>    
                        </div> 
                        <div class="card-body">
                            <div id="paymentList"></div>
                        </div>   
                    </div> 
                                `;

                    const paymentList = document.querySelector('#paymentDetailsModal #paymentDetails #paymentList');
                    const paymentTotal = document.querySelector('#paymentDetailsModal #paymentDetails #paymentTotal');

                    if (payments.length < 1) {
                        paymentList.innerHTML = `<p class="text-center">No payment as of the moment</p>`;
                    } else {
                        payments.forEach(payment => {
                            paymentList.innerHTML += `
                            <div class="d-flex justify-content-evenly align-items-center mt-4">
                                <div class="d-flex flex-column">
                                    <b>Contact Number:</b> 
                                    ${payment.contact_number}
                                </div>
                                <div class="d-flex flex-column">
                                    <b>Referrence Number:</b> 
                                    ${payment.referrence_number}
                                </div>
                                <div class="d-flex flex-column">
                                    <b>Account Name:</b> 
                                    ${payment.account_name}
                                </div>
                                <div class="d-flex flex-column">
                                    <b>Amount:</b> 
                                    ${payment.amount}
                                </div>
                                <div class="d-flex flex-column">
                                    <b>Type:</b> 
                                    ${payment.type === 'downpayment' ? 'Down Payment' :  payment.type === 'balance' ? 'Balance Payment' : 'Full Payment'}
                                   
                                </div>
                                <a href="${payment.file_url}" target="_blank">
                                     ${payment.file_url ? `<img src="${payment.file_url}" alt="Payment Image" width="100">` : ''}
                                    </a>
                                ${payment.is_verified ? `<p class="badge text-bg-success">Payment Verified</p>` : `<button class="btn btn-sm btn-primary" onclick="paymentVerified('${payment.id}', '${id}')">Verified Payment</button>`}
                            </div>
                        `;
                        })

                    }

                })
                .catch(error => {
                    console.error('Error fetching order payment details:', error);
                    swalMessage("Unable to load order payment details data");
                });
        }

        function paymentVerified(id, orderPaymentId) {
            ajaxPostRequest('order/api/payment/verified/' + id, [])
                .then(response => {
                    if (response.message) {
                        swalMessage(response.message, "Payment Exceed", "warning");

                    } else {
                        fetchPaymentDetails(orderPaymentId);
                        swalMessage("Payment Verified", "Success", "success", true);
                    }
                })
                .catch(error => {
                    console.error('Error verifying payment:', error);
                    swalMessage("Unable to process verified payment");
                });
        }

        function appendOrderTopDetails(data, type) {
            if (type === "Vest") {
                modalTop.innerHTML = `
                    <h1 class="measurement-title">Top Measurement</h1>
                    <div class="d-flex flex-column">
                        <p><strong>Armhole:</strong> ${data.vest_armhole}</p>
                        <p><strong>Full Length:</strong> ${data.vest_full_length}</p>
                        <p><strong>Shoulder Width:</strong> ${data.vest_shoulder_width}</p>
                        <p><strong>Neck Circumference:</strong> ${data.vest_neck_circumference}</p>
                    </div>
                `;
            }

            if (type === "Polo") {
                modalTop.innerHTML = `
                    <h1 class="measurement-title">Top Measurement</h1>
                    <div class="d-flex flex-column">
                        <p><strong>Chest:</strong> ${data.polo_chest}</p>
                        <p><strong>Polo's Length:</strong> ${data.polo_length}</p>
                        <p><strong>Hips:</strong> ${data.polo_hips}</p>
                        <p><strong>Shoulder:</strong> ${data.polo_shoulder}</p>
                        <p><strong>Sleeve Length:</strong> ${data.polo_sleeve}</p>
                        <p><strong>Armhole:</strong> ${data.polo_armhole}</p>
                        <p><strong>Lower Arm Girth:</strong> ${data.polo_lower_arm_girth}</p>
                    </div>
                `;
            }

            if (type === "Blazer") {
                modalTop.innerHTML = `
                    <h1 class="measurement-title">Top Measurement</h1>
                    <div class="d-flex flex-column">
                        <p><strong>Armhole:</strong> ${data.blazer_armhole}</p>
                        <p><strong>Back Width:</strong> ${data.blazer_back_width}</p>
                        <p><strong>Chest:</strong> ${data.blazer_chest}</p>
                        <p><strong>Hips:</strong> ${data.blazer_hips}</p>
                        <p><strong>Length:</strong> ${data.blazer_length}</p>
                        <p><strong>Lower Arm Girth:</strong> ${data.blazer_lower_arm_girth}</p>
                        <p><strong>Shoulder Width:</strong> ${data.blazer_shoulder_width}</p>
                        <p><strong>Sleeve Length:</strong> ${data.blazer_sleeve_length}</p>
                        <p><strong>Waist:</strong> ${data.blazer_waist}</p>
                        <p><strong>Wrist:</strong> ${data.blazer_wrist}</p>
                    </div>
                `;
            }
            if (type === "Blouse") {
                modalTop.innerHTML = `
                    <h1 class="measurement-title">Top Measurement</h1>
                    <div class="d-flex flex-column">
                        <p><strong>Bust:</strong> ${data.blouse_bust}</p>
                        <p><strong>Blouse Length:</strong> ${data.blouse_length}</p>
                        <p><strong>Waist:</strong> ${data.blouse_waist}</p>
                        <p><strong>Figure:</strong> ${data.blouse_figure}</p>
                        <p><strong>Hips:</strong> ${data.blouse_hips}</p>
                        <p><strong>Shoulder:</strong> ${data.blouse_shoulder}</p>
                        <p><strong>Sleeve Length:</strong> ${data.blouse_sleeve}</p>
                        <p><strong>Arm Hole:</strong> ${data.blouse_arm_hole}</p>
                        <p><strong>Lower Arm Girth:</strong> ${data.blouse_lower_arm_girth}</p>
                    </div>
                `;
            }

            if (type === 'N/A') {
                modalTop.innerHTML = `
                    <h1 class="measurement-title">Bottom Measurement</h1>
                    <div class="d-flex flex-column">
                        <p>No top measurements available.</p>
                    </div>
                `;
            }
        }

        function appendOrderBottomDetails(data, type) {
            console.log("bottom", type);
            if (type === "Pants") {
                modalBottom.innerHTML = `
                    <h1 class="measurement-title">Bottom Measurement</h1>
                    <div class="d-flex flex-column">
                        <p><strong>Pants Length:</strong> ${data.pants_length}</p>
                        <p><strong>Waist:</strong> ${data.pants_waist}</p>
                        <p><strong>Hip:</strong> ${data.pants_hips}</p>
                        <p><strong>Crotch:</strong> ${data.pants_scrotch}</p>
                        <p><strong>Knee Height:</strong> ${data.pants_knee_height}</p>
                        <p><strong>Knee Circumference:</strong> ${data.pants_knee_circumference}</p>
                        <p><strong>Bottom Circumference:</strong> ${data.pants_bottom_circumferem}</p>
                    </div>
                `;
            }

            if (type === "Skirt") {
                modalBottom.innerHTML = `
                    <h1 class="measurement-title">Bottom Measurement</h1>
                    <div class="d-flex flex-column">
                        <p><strong>Skirt Length:</strong> ${data.skirt_length}</p>
                        <p><strong>Waist:</strong> ${data.skirt_waist}</p>
                        <p><strong>Hips:</strong> ${data.skirt_hips}</p>
                        <p><strong>Hip Depth:</strong> ${data.skirt_hip_depth}</p>
                    </div>
                `;
            }

            if (type === "Short") {
                modalBottom.innerHTML = `
                    <h1 class="measurement-title">Bottom Measurement</h1>
                    <div class="d-flex flex-column">
                        <p><strong>Waist:</strong> ${data.short_waist}</p>
                        <p><strong>Hip:</strong> ${data.short_hips}</p>
                        <p><strong>Short Length:</strong> ${data.short_length}</p>
                        <p><strong>Thigh Circumference:</strong> ${data.short_thigh_circumference}</p>
                        <p><strong>Inseam Length:</strong> ${data.short_inseam_length}</p>
                        <p><strong>Leg Opening:</strong> ${data.short_leg_opening}</p>
                        <p><strong>Rise:</strong> ${data.short_rise}</p>
                    </div>
                `;
            }

            if (type === 'N/A') {
                modalBottom.innerHTML = `
                    <h1 class="measurement-title">Bottom Measurement</h1>
                    <div class="d-flex flex-column">
                        <p>No bottom measurements available.</p>
                    </div>
                `;
            }
        }

        function appendOrderOtherDetails(data) {
            console.log(data);

            modalOther.innerHTML = `
                <h1 class="measurement-title fs-2">Customized Details</h1>
                <div class="d-flex flex-column">
                    <p><strong>Uniform Set:</strong> ${data.set}</p>
                    <p><strong>School:</strong> ${data.school}</p>
                    <p><strong>Uniform Top:</strong> ${data.top ?? 'N/A'}</p>
                    <p><strong>Uniform Bottom:</strong> ${data.bottom ?? 'N/A'}</p>
                    <p><strong>Threads:</strong> ${data?.additional_items?.threads ?? 'N/A'}</p>
                    <p><strong>Zipper:</strong> ${data?.additional_items?.zipper ?? 'N/A'}</p>
                    <p><strong>School Seal:</strong> ${data?.additional_items?.school_seal ?? 'N/A'}</p>
                    <p><strong>Buttons:</strong> ${data?.additional_items?.buttons ?? 'N/A'}</p>
                    <p><strong>Hook and Eye:</strong> ${data?.additional_items?.hook_and_eye ?? 'N/A'}</p>
                    <p><strong>Tela:</strong> ${data?.additional_items?.tela ?? 'N/A'}</p>
                </div>
            `;
        }

        function appendOrderReadyMadeDetails(data) {

            modalReadyMade.innerHTML = `
                <h1 class="measurement-title">Ready Made Details</h1>
                <div class="d-flex justify-content-lg-evenly align-items-center mt-4">
                
                    <div class="d-flex flex-column">
                    <p><strong>Uniform Set:</strong> ${data.set}</p>
                    <p><strong>School:</strong> ${data.school}</p>
                    <p><strong>Uniform Top:</strong> ${data.top ?? 'N/A'}</p>
                    <p><strong>Uniform Bottom:</strong> ${data.bottom ?? 'N/A'}</p>
                    <p><strong>Quantity:</strong> ${data.quantity ?? 'N/A'}</p>
                    <p><strong>Size:</strong> ${data.size ?? 'N/A'}</p>
                    
                </div>
                <div class="d-flex flex-column">
                    <p><strong>Threads:</strong> ${data?.additional_items?.threads ?? 'N/A'}</p>
                    <p><strong>Zipper:</strong> ${data?.additional_items?.zipper ?? 'N/A'}</p>
                    <p><strong>School Seal:</strong> ${data?.additional_items?.school_seal ?? 'N/A'}</p>
                    <p><strong>Buttons:</strong> ${data?.additional_items?.buttons ?? 'N/A'}</p>
                    <p><strong>Hook and Eye:</strong> ${data?.additional_items?.hook_and_eye ?? 'N/A'}</p>
                    <p><strong>Tela:</strong> ${data?.additional_items?.tela ?? 'N/A'}</p>
                </div>
                </div>
            `;
        }

        function appendUploadedFiles(data) {

            let fileHtml = `
                <h1 class="measurement-title">Uploaded Files</h1>
                <div class="d-flex justify-content-lg-evenly align-items-center mt-4">
            `;

            data.file_url.forEach(file => {
                fileHtml += `
                  <a href="${file}" target="_blank">
                                                    <img src="${file}" alt="Order Image"
                                                        class="img-thumbnail" width="150" height="150">
                                                </a>
                `
            });

            fileHtml += `</div>`;
            modalFiles.innerHTML = fileHtml;
        }
    </script>
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
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->user->fullname }}</td>
                                            <td>{{ $order->order_type }}</td>
                                            <td>{{ $order->payment_status }}</td>
                                            <td>{{ $order->top}}</td>
                                            <td>{{ $order->bottom}}</td>
                                            <td class="text-center">
                                                @if ($order->status === 'pending')
                                                    <span class="badge rounded-pill text-bg-secondary">Pending</span>
                                                @elseif ($order->status === 'in-progress')
                                                    <span class="badge rounded-pill text-bg-info">In Progress</span>
                                                @elseif ($order->status === 'done')
                                                    <span class="badge rounded-pill text-bg-primary">Done</span>
                                                @else
                                                    <span class="badge rounded-pill text-bg-success">Completed</span>
                                                @endif
                                            </td>
                                            <td width="2%">
                                                <div class="dropdown">
                                                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @if (Str::lower($order->payment_status) === 'down payment' && $order->status === 'pending' || Str::lower($order->payment_status) === 'payment settled' && $order->status === 'pending')
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

                                                        @if ($order->status === 'done' && Str::lower($order->payment_status) === 'payment settled' && $order->payments->isEmpty() && $order->payments->last()->type === 'full')
                                                            <x-admin.order-update-status :id="$order->id"
                                                                icon="bi-arrow-right-circle" status="completed"
                                                                button="Move to Complete" />
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
    <div class="modal fade" id="viewOrderModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="viewOrderModalLabel" aria-hidden="true">
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
    <div class="modal fade" id="paymentDetailsModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="paymentDetailsModalLabel"
        aria-hidden="true">
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
    <div class="modal fade" id="addDiscountModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addDiscountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addDiscountModalLabel">Add Discount</h1>
                </div>
                <div class="modal-body">
                    <x-admin.input-field name="discount" type="number" label="Discount (%)" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="discountBackButton" data-bs-dismiss="modal">Back</button>
                    <button type="button" class="btn btn-primary" id="discountSaveButton">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection
