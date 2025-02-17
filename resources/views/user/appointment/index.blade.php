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
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/user/css/appointment.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="{{ asset('assets/user/js/appointment.js') }}"></script>
@endpush
