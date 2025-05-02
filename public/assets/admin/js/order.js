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

$("#discountSaveButton").on('click', function (e) {
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



function fetchPaymentDetails(id) {
    ajaxGetRequest(`order/api/view/${id}`)
        .then(response => {

            const data = response.data;
            const invoice = data.invoice;
            const payments = data.payments;
            console.log(!invoice.is_paid);
            console.log(data.status === 'pending');

            discount = invoice.discount;
            paymentInvoice.innerHTML = `
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="card-title">Invoice</div>
                                    <div>
                                        ${!invoice.is_paid && data.status === 'pending' ? `
                                                <button type="button" class="btn btn-outline-primary btn-sm print-hidden" onclick="addDiscount('${invoice.id}')">
                                                    ${invoice.discount === null ? 'Add' : 'Update'} Discount (%)
                                                </button>
                                            ` : `
                                                <span class="badge text-bg-success print-hidden">Paid</span>
                                            `}

                                    <button type="button" class="btn btn-sm btn-secondary print-hidden" onclick="printModalContent()">Print</button>
                                        ${data.status === 'done' ?  `<button type="button" class="btn btn-sm btn-outline-success print-hidden" onclick="settleBalanceModal('${data.id}')">Settle Balance</button>` : ''}
                                
                                    </div>
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
                                <div class="row">
                                    <span class="fw-bold">Balance: </span>
                                    <span>${invoice.total - invoice.total_payment ?? 0.00}</span>
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
                                    ${payment.type === 'downpayment' ? 'Down Payment' : payment.type === 'balance' ? 'Balance Payment' : 'Full Payment'}
                                   
                                </div>
                                <a href="${payment.file_url}" target="_blank">
                                     ${payment.file_url ? `<img src="${payment.file_url}" alt="Payment Image" width="100">` : ''}
                                    </a>
                                ${payment.is_verified ? `<p class="badge text-bg-success print-hidden">Payment Verified</p>` : `<button class="btn btn-sm btn-primary print-hidden" onclick="paymentVerified('${payment.id}', '${id}')">Verified Payment</button>`}
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
    return Swal.fire({
        icon: 'info',
        title: "Verify Payment",
        text: "Are you sure you want to accept this payment?",
        showCancelButton: true,
        cancelButtonText: "Cancel",
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Verify it!",
        confirmButton: "OK",
    }).then((result) => {
        if (result.isConfirmed) {
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
    });

}