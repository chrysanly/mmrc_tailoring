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
    @include('user.appointment.confirm_appointment_modal')
    @include('user.appointment.appointment_guide_modal')

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/user/css/appointment.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script>
        const postRoute = "{{ route('user.appointment.store') }}";
        const getAvailableTimeByDate = "{{ route('user.appointment.get-available-time-by-date') }}";
    </script>
    <script src="{{ asset('assets/user/js/appointment.js') }}"></script>
@endpush
