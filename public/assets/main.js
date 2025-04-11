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

async function fetchRequest(url, method, data = null) {
    return new Promise(async (resolve, reject) => {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            let options = {
                method: method.toUpperCase(),
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                }
            };

            if (['POST', 'PUT', 'PATCH'].includes(method.toUpperCase()) && data) {
                if (data instanceof FormData) {
                    if (method.toUpperCase() !== 'POST') {
                        data.append('_method', method.toUpperCase());
                        options.method = 'POST'; // Send as POST because Laravel will process _method
                    }
                    options.body = data;
                } else {
                    options.headers['Content-Type'] = 'application/json';
                    options.body = JSON.stringify(data);
                }
            }


            const response = await fetch(url, options);

            // Check if response is JSON before parsing
            const contentType = response.headers.get("content-type");
            let responseData;

            if (contentType && contentType.includes("application/json")) {
                responseData = await response.json();
            } else {
                responseData = await response.text(); // Get HTML error response
                
                throw new Error("Unexpected response format: " + responseData);
            }
            
            if (!response.ok) {
                
                if (responseData.errors) {
                    let errorMessages = Object.values(responseData.errors)
                        .flat()
                        .map(msg => `<li>${msg}</li>`)
                        .join("");

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Errors',
                        html: `<ul style="text-align:left;">${errorMessages}</ul>` // Display as bullet points
                    });
                }
                if (response.status === 422) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: `<ul style="text-align:left;">${responseData.message}</ul>` // Display as bullet points
                    });
                }
                return reject(responseData);
            } else {
                if (responseData.message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: responseData.message
                    });
                }
            }

            resolve(responseData);
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Request Failed',
                text: error.message || 'Something went wrong!'
            });
            reject(error);
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

const consoleLog = (title, data) => {
    console.log(`${title} : ` + data);
}