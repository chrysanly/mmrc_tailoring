@push('styles')
<style>
    #make-appointment {
        /* background: url("{{ asset('images/user/appointment.jpg') }}") no-repeat center center/cover; */
        height: 100vh;
    }

    :root {
        --fc-border-color: var(--dark-color);
        --fc-daygrid-event-dot-width: 5px;
    }

    .fc-view-harness {
        border: 1px solid var(--fc-border-color);
        height: 75vh !important;
    }

    .fc-day {
        cursor: pointer;
    }

    .fc-daygrid-day-number {
        text-decoration: none;
        color: var(--red-color);
        font-weight: bold;
    }

    .fc-col-header-cell-cushion {
        text-decoration: none;
        text-transform: uppercase;
        color: var(--light-red-color);
    }

    .fc-next-button.fc-button-primary:hover,
    .fc-prev-button.fc-button-primary:hover {
        background-color: var(--red-color);
        border-color: var(--red-color);
    }

    .fc-next-button.fc-button-primary,
    .fc-prev-button.fc-button-primary {
        background-color: var(--dark-color);
        border-color: var(--dark-color);
    }

    .fc-button.fc-today-button.fc-button-primary {
        background-color: var(--dark-color);
        border-color: var(--dark-color);
        text-transform: uppercase;
    }

    .appointment-count-badge {
        position: absolute;
        right: 70px;
        top: 40px;
        font-size: larger;
        background-color: var(--red-color)
    }

    .fc-event-title-container,
    .fc-daygrid-event-harness {
        display: none;
    }

    .disabled-day{
        background-color: #f8d7da !important;
        cursor: default;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const limit = 5;

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: function(fetchInfo, successCallback, failureCallback) {
                fetch('appointment/fetch-appointments')
                    .then(response => response.json())
                    .then(data => {
                        const events = data.appointments.map(appointment => ({
                        start: appointment.date,
                            extendedProps: {
                            count: appointment.count
                            }
                        }));
                        successCallback(events);
                    })
                    .catch(error => failureCallback(error));
            },
            eventDidMount: function(info) {
                const events = info.el.parentNode.querySelectorAll('.fc-event');
                if (events.length > limit) {
                    for (let i = limit; i < events.length; i++) {
                        events[i].style.display = 'none';
                    }
                }
            },
            dateClick: function(info) {
                const dayCell = document.querySelector(`.fc-daygrid-day[data-date="${info.dateStr}"]`);
                if (!dayCell.classList.contains('disabled-day')) {
                    const selectedDate = info.dateStr;
                    const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
                    document.getElementById('modalDate').innerText = selectedDate;
                    document.getElementById('selectedDate').value = selectedDate;
                    modal.show();
                }
            },
            eventDidMount: function(info) {
                const date = info.event.startStr;
                if (info.event.extendedProps.count > 0) {
                    const countBadge = document.createElement('span');
                    countBadge.className = 'badge bg-primary appointment-count-badge';
                    countBadge.innerText = info.event.extendedProps.count;
                    const dayCell = document.querySelector(`.fc-daygrid-day[data-date="${date}"] .fc-daygrid-day-number`);
                    if (dayCell) {
                        dayCell.appendChild(countBadge);
                    }
                }
                if (info.event.extendedProps.count >= limit) {
                const dayCell = document.querySelector(`.fc-daygrid-day[data-date="${info.event.startStr}"]`);
                if (dayCell) {
                dayCell.classList.add('disabled-day');
                }
                }
            }
        
        });

        calendar.render();
    });
</script>
@endpush


<!-- Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                You have selected <span id="modalDate" class="text-danger fw-bolder"></span>. Do you want to confirm
                this appointment?

                <form action="{{ route('user.appointment.store') }}" method="post" id="form-appointment">
                    @csrf
                    <input type="hidden" name="date" id="selectedDate">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit" form="form-appointment">Confirm</button>
            </div>
        </div>
    </div>
</div>


<x-layouts.user.app title="Appointment">

    <section id="make-appointment">
        <div class="container py-5">
            <h1 class="text-center fw-bold">Make an Appointment</h1>

            @if(session('error'))
            <div class="alert alert-danger col-6 mx-auto">{{ session('error') }}</div>
            @enderror  
            @if(session('success'))
            <div class="alert alert-success col-6 mx-auto">{{ session('success') }}</div>
            @enderror  
            <div id='calendar'></div>
        </div>
    </section>

</x-layouts.user.app>