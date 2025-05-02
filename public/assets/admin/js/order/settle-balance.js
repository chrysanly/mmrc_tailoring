let selectedId;

// settleBalanceSaveBtn
// settleBalanceCancelBtn



const settleBalanceModal = (id) => {
    orderId = id;
    $("#settleBalanceModal").modal('show');
    $("#paymentDetailsModal").modal('hide');
}

$("#settleBalanceCancelBtn").on('click', function (e) {
    e.preventDefault();
    $("#paymentDetailsModal").modal('show');
    $("#settleBalanceModal").modal('hide');
})

$("#settleBalanceSaveBtn").on('click', function (e) {
    e.preventDefault();
    settleBalance(orderId);
})

const settleBalance = (id) => {
    return Swal.fire({
        icon: 'info',
        title: "Settle Balance",
        text: "Are you sure you want to settle the balance?",
        showCancelButton: true,
        cancelButtonText: "Cancel",
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, settle it!",
        confirmButton: "OK",
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append("account_name", $("#account_name").val());
            formData.append("ref_number", $("#ref_number").val());
            formData.append("contact_number", $("#contact_number").val());
            
            ajaxPostRequest('order/api/payment/settle-balance/' + id, formData)
                .then(response => {
                    swalMessage("Payment Settled", "Success", "success", true);
                    setTimeout(() => {
                        window.location.href = response.route;
                    }, 500);
                })
                .catch(error => {
                    console.error('Error verifying payment:', error);
                    swalMessage("Unable to process settle of balance");
                });
        }
    });
}