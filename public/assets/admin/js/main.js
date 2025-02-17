function swalMessage(message, title = "Validation Error", icon = "error", refresh = false) {
    return Swal.fire({
        icon: icon,
        title: title,
        html: message,
        confirmButton: "OK",
    }).then((result) => {
        if (refresh && result.isConfirmed) {
            location.reload(); // Refresh the page when "OK" is clicked
        }
    });
}

function ajaxGetRequest(url) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                resolve(response);
            },
            error: function (xhr, status, error) {
                reject(xhr);
            }
        });
    });
}

function ajaxPostRequest(url, data) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                // Disable the submit button
                $('#submitButton').prop('disabled', true);
            },
            success: function (response) {
                resolve(response);
            },
            error: function (xhr, status, error) {
                reject(xhr);
            },
            complete: function() {
                // Re-enable the submit button
                $('#submitButton').prop('disabled', false);
            }
        });
    });
}

function ajaxPatchRequest(url, data) {
    console.log(...data);

    
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                // Disable the submit button
                $('#submitButton').prop('disabled', true);
            },
            success: function (response) {
                resolve(response);
            },
            error: function (xhr, status, error) {
                reject(xhr);
            },
            complete: function() {
                // Re-enable the submit button
                $('#submitButton').prop('disabled', false);
            }
        });
    });
}

function ajaxDeleteRequest(url) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                resolve(response);
            },
            error: function (xhr, status, error) {
                reject(xhr);
            },
            complete: function() {
                // Re-enable the submit button
                $('#submitButton').prop('disabled', false);
            }
        });
    });
}