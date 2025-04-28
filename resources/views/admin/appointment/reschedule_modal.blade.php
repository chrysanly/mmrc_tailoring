<div class="modal fade" id="recheduleModal" tabindex="-1" aria-labelledby="recheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="recheduleModalLabel">Reschedule</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <x-admin.input-field label="Date" type="date" name="dateInput" :attrs="['min' => now()->toDateString(), 'max' => now()->addMonth()->toDateString()]"/>
                    <select class="form-select mt-4" id="timeSelect" name="time" aria-label="Default select example">
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitResched">Resched</button>
                </div>
            </div>
        </div>
    </div>