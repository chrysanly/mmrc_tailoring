const orderModal = document.getElementById('viewOrderDetails');
const modalTop = document.querySelector('#viewOrderDetails #top');
const modalBottom = document.querySelector('#viewOrderDetails #bottom');
const modalOther = document.querySelector('#viewOrderDetails #other');
const modalReadyMade = document.querySelector('#viewOrderDetails #ready-made');
const modalFiles = document.querySelector('#viewOrderDetails #file_uploads');

const viewOrderDetails = (id) => {
    fetchOrder(id);
    $("#viewOrderDetails").modal('show');
}

function fetchOrder(id) {
    ajaxGetRequest(`api/view/${id}`)
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


// Payment Details

const paymentInvoice = document.querySelector('#paymentDetailsModal #invoice');
const paymentDetails = document.querySelector('#paymentDetailsModal #paymentDetails');

function fetchPaymentDetails(id) {
    ajaxGetRequest(`/user/order/api/view/${id}`)
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
                                <button type="button" class="btn btn-secondary btn-sm print-hidden" onclick="printModalContent()">Print</button>
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
                                    ${payment.type === 'downpayment' ? 'Down Payment' : payment.type === 'balance' ? 'Balance Payment' : 'Full Payment'}
                                   
                                </div>
                                <a href="${payment.file_url}" target="_blank">
                                     ${payment.file_url ? `<img src="${payment.file_url}" alt="Payment Image" width="100">` : ''}
                                    </a>
                                ${payment.is_verified ? `<p class="badge text-bg-success">Payment Verified</p>` : `<p class="badge text-bg-danger">Not Verified</p>`}
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

function viewPaymentDetails(id) {
    paymentId = id;
    $('#paymentDetailsModal').modal('show');
    fetchPaymentDetails(id);
}

function printModalContent() {
    const modalContent = document.querySelector('#paymentDetailsModal').innerHTML; // Replace '.modal-content' with your modal's class or ID
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
        <head>
            <title>Payment Details</title>
            <link rel="preconnect" href="https://fonts.bunny.net">
            <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

            <link rel="stylesheet" href="{{ asset('assets/css/welcome.css') }}">
            <style>
                @page {
                    size: landscape;
                    margin: 20mm;
                }
                img { display: none; }
                .print-hidden {
                    display: none;
                }
            </style>
        </head>
        <body>
            ${modalContent}
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}