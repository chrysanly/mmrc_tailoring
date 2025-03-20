@extends('layouts.user.app')

@section('title', 'Appointment')

@section('content')
     <section id="make-appointment">
        <div class="container py-5">
            <h1 class="text-center fw-bold">Make an Appointment</h1>
           
            <div id='calendar' class="mb-5"></div>
            <span id="max_limit" style="display: none;">{{ $limit }}</span>
        </div>
    </section>

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
                
                    <input type="hidden" id="selectedDate">
                    <x-user.input-field type="time" name="from" label="Time From" class="w-100" />
                    <x-user.input-field type="time" name="to" label="Time To" />
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="appointmentForm">Confirm</button>
            </div>
        </div>
    </div>
</div>


    <!-- Modal -->
<div class="modal fade" id="appointmentGuideModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="appointmentGuideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
           
            <div class="modal-body">
                
                <div class="d-flex justify-content-between align-items-center">
                    <p class="fw-bold mt-2">APPOINTMENT GUIDES:</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
              <ol>
                <li>Choose a date from the calendar.</li>
                <li>
                    Select the available date:
                    <ul>
                        <li>Red <div style="width: 15px; height: 10px; background-color: red; display: inline-block; border: 1px solid black;"></div> Background means full appointment</li>
                        <li>White <div style="width: 15px; height: 10px; background-color: white; display: inline-block; border: 1px solid black;"></div> Background means available appointment</li>
                        <li>Gray <div style="width: 15px; height: 10px; background-color: gray; display: inline-block; border: 1px solid black;"></div> Background means past date</li>
                    </ul>
                </li>
                <li>
                    Choose start time and end time of appointment and select <b>Confirm</b> button.
                </li>
              </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/user/css/appointment.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script>
        const postRoute = "{{ route('user.appointment.store') }}";
    </script>
    <script src="{{ asset('assets/user/js/appointment.js') }}"></script>
@endpush
