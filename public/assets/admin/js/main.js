function swalMessage(message, title = "Validation Error", icon = "error") {
    return Swal.fire({
        icon: icon,
        title: title,
        html: message,
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