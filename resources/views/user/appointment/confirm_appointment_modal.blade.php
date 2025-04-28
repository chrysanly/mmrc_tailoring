<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    You have selected <span id="modalDate" class="text-danger fw-bolder"></span>. Do you want to confirm
                    this appointment?

                    <input type="hidden" id="selectedDate">
                    <select class="form-select mt-4" id="timeSelect" name="time" aria-label="Default select example">
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="appointmentForm">Confirm</button>
                </div>
            </div>
        </div>
    </div>