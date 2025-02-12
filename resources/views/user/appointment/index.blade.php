@push('styles')
    <style>
        #make-appointment {
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
            top: 5px;
            font-size: larger;
            background-color: var(--red-color);
            color: white;
            padding: 4px 8px;
            border-radius: 50%;
        }

        .fc-event-title-container,
        .fc-daygrid-event-harness {
            display: none;
        }

        .max-limit-day {
            background-color: #f8d7da !important;
            cursor: not-allowed;
        }

        .disabled-day {
            background-color: #e9ecef;
            cursor: not-allowed;
        }

        .fc-daygrid-day-frame {
            overflow: hidden;
            overflow-y: scroll;
            scrollbar-width: none; /* For Firefox */
        }

        .fc-daygrid-day-frame::-webkit-scrollbar {
            display: none; /* For Chrome, Safari, and Opera */
        }

        .fc td{
            padding:5px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script src="{{ asset('assets/user/js/appointment.js') }}"></script>
@endpush

<!-- Modal -->
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

                <form action="{{ route('user.appointment.store') }}" method="post" id="form-appointment"
                    class="mt-4">
                    @csrf
                    <input type="hidden" name="date" id="selectedDate">
                    <x-user.input-field type="time" name="time_from" label="Time From" class="w-100" />
                    <x-user.input-field type="time" name="time_to" label="Time To" />
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
            @if (session('error'))
                <div class="alert alert-danger col-6 mx-auto">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success col-6 mx-auto">{{ session('success') }}</div>
            @endif
            <div id='calendar'></div>
            <span id="max_limit">{{ $limit }}</span>
        </div>
    </section>
</x-layouts.user.app>
