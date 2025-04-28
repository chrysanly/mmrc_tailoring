let selectedId = null;
let modalElement;
let bsModal;

function openModal(modalId, id) {
    selectedId = id;
    modalElement = document.getElementById(modalId);
    if (modalElement) {
        bsModal = new bootstrap.Modal(modalElement);
        bsModal.show();
    } else {
        console.error("Modal with ID " + modalId + " not found.");
    }
}

$("#submitResched").click(function () {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, resched it!"
    }).then((result) => {
        if (result.isConfirmed) {
            submitAppointment(selectedId);
        }
    });
});

$("#submitCancel").click(function () {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, cancel it!"
    }).then((result) => {
        if (result.isConfirmed) {
            cancelAppointment(selectedId);
        }
    });
});

const submitAppointment = async (id) => {
    const url = "appointment/resched/" + id;
    const formData = new FormData();
    formData.append('date', $("#dateInput").val());
    formData.append('time', $("#timeSelect").val());
    try {
        await fetchRequest(url, 'patch', formData);
        location.reload();
    } catch (error) {
        console.error("Error resched appointment:", error);
    }
};

const cancelAppointment = async (id) => {
    const url = "appointment/cancel/" + id;

    const formData = new FormData();
    formData.append("reason", $("#reason").val());
    try {
        await fetchRequest(url, 'patch', formData);
        $("#cancelModal").modal('hide');
        setTimeout(() => {
            location.reload();
        }, 3000);
    } catch (error) {
        console.error("Error cancelling appointment:", error);
    }
}


// Reschedule Appointment
const dateInput = document.getElementById('dateInput');

$("#dateInput").on('change', function () {
    const selectedDate = $(this).val();
    const timeSelect = document.getElementById('timeSelect');

    timeSelect.innerHTML = `<option selected disabled> --SELECT TIME--</option>`;

    fetch(getAvailableTimeByDate + `?date=${selectedDate}`)
        .then(response => response.json())
        .then(data => {
            data.forEach(time => {
                const option = document.createElement('option');
                option.value = time.time;
                if (time.status !== 'available') {
                    option.classList.add('text-bg-danger', 'text-white');
                }
                option.disabled = time.status === 'available' ? false : true;
                option.textContent = `${time.time}`;
                timeSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error("Error fetching available time:", error);
        });
});

// End Reschedule Appointment