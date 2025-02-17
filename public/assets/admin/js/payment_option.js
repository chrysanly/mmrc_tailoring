const name = $('#name');
const account_number = $('#account_number');
const account_name = $('#account_name');
let selectedPaymentOption;

$(document).ready(function () {
    $('#submitButton').on('click', function (event) {
        event.preventDefault();

        const formData = new FormData();
        formData.append('name', $('#name').val());
        formData.append('account_number', account_number.val());
        formData.append('account_name', account_name.val());

        const isUpdate = $("#submitButton").text() === "Update";
        if (isUpdate) {
        formData.append("_method", "PATCH");
        }
        const url = isUpdate && selectedPaymentOption ? `payment-option/api/update/${selectedPaymentOption}` : 'payment-option/api/store';

        ajaxPostRequest(url, formData)
            .then(() => {
                swalMessage("", `Payment option ${isUpdate ? 'updated' : 'saved'} successfully`, "success");
                fetchPaymentOptions();
                clearFields();
            })
            .catch(error => {
                if (error.responseJSON && error.responseJSON.errors) {
                    const errors = error.responseJSON.errors;
                    let errorMessage = '';
                    for (const key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            errorMessage += errors[key].join('<br>') + '<br>';
                        }
                    }
                    swalMessage(errorMessage);
                } else {
                    swalMessage(`Failed to ${isUpdate ? 'update' : 'save'} payment option.`);
                }
            });
    });

    $("#clear-button").on('click', function () {
        clearFields();
    });

    function clearFields() {
        name.val('');
        account_number.val('');
        account_name.val('');
        $("#submitButton").text("Save");
    }
});

function fetchPaymentOptions(page = 1) {
    ajaxGetRequest(`payment-option/api/get-all?page=${page}`)
        .then(response => {
            const tbody = $('table tbody');
            tbody.empty();

            const data = response.data.data;
            const pagination = response.data;

            if (data.length === 0) {
                tbody.append('<tr><td colspan="4" class="text-center">No payment options available.</td></tr>');
            } else {
                data.forEach(option => {
                    const row = `<tr>
                        <td>${option.name}</td>
                        <td>${option.account_number}</td>
                        <td>${option.account_name}</td>
                        <td widt="15%">
                        <button type="button" class="btn btn-primary" onclick="editPaymentOption('${option.id}')">Edit</button>
                        <button type="button" class="btn btn-danger" onclick="deletePaymentOption('${option.id}')">Delete</button>
                        </td>
                    </tr>`;
                    tbody.append(row);
                });
            }

            const paginationContainer = $('#pagination');
            paginationContainer.empty();

            if (pagination.last_page > 1) {
                paginationContainer.append('<div class="d-flex justify-content-center mt-3"><nav><ul class="pagination"></ul></nav></div>');
                const paginationList = paginationContainer.find('.pagination');

                paginationList.append(`<li class="page-item ${pagination.current_page === 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${pagination.current_page - 1}" onclick="return false;">Previous</a></li>`);

                for (let i = 1; i <= pagination.last_page; i++) {
                    paginationList.append(`<li class="page-item ${i === pagination.current_page ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}" onclick="return false;">${i}</a></li>`);
                }

                paginationList.append(`<li class="page-item ${pagination.current_page === pagination.last_page ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${pagination.current_page + 1}" onclick="return false;">Next</a></li>`);
            }
        })
        .catch(error => {
            console.error('Error fetching payment options:', error);
            swalMessage("Failed to fetch payment options.");
        });

   
}

$(document).on('click', '.pagination .page-link', function (event) {
    event.preventDefault();
    const page = $(this).data('page');
    fetchPaymentOptions(page);
});

function deletePaymentOption(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this payment option!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        dangerMode: true,
    }).then((result) => {
        if (result.isConfirmed) {
            ajaxDeleteRequest(`payment-option/api/destroy/${id}`)
                .then(() => {
                    swalMessage("", "Payment option has been deleted!", "success");
                    fetchPaymentOptions();
                })
                .catch(() => {
                    swalMessage("", "Error", "error");
                });
        }
    });
}

function editPaymentOption(id) {
    ajaxGetRequest(`payment-option/api/edit/${id}`)
        .then(response => {
            selectedPaymentOption = id;
            const data = response.data;
            name.val(data.name);
            account_number.val(data.account_number);
            account_name.val(data.account_name);
            $("#submitButton").text("Update");
        })
        .catch(error => {
            console.error('Error fetching payment options:', error);
            swalMessage("Failed to fetch payment options.");
        });
}


fetchPaymentOptions();
