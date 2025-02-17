@extends('layouts.admin.app')

@section('title', 'Appointments')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h3 class="mb-4">View Appointment Measurement</h3>

            <div class="card mb-4 shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h5 class="card-title mb-0">Appointment Details</h5>
                </div>
                <div class="card-body p-4">
                    <h4>Schedule By: {{ $appointment->user->fullname }}</h4>
                    <div class="row mb-3">
                        <div class="col-md-6 fw-bold">Date: <span class="fw-light">{{ $appointment->date }}</span></div>
                        <div class="col-md-6 fw-bold">Time:
                            <span class="fw-light">
                                {{ \Carbon\Carbon::parse($appointment->time_from)->format('g:i A') .
                                    ' - ' .
                                    \Carbon\Carbon::parse($appointment->time_to)->format('g:i A') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4 shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h5 class="card-title mb-0">Measurement Details</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-6 fw-bold">Uniform Set: <span class="fw-light">{{ $appointment->set }}</span>
                        </div>
                        <div class="col-md-6 fw-bold">Uniform School: <span
                                class="fw-light">{{ $appointment->school }}</span></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 fw-bold">Uniform Top: <span
                                class="fw-light">{{ $appointment->top ?? 'N/A' }}</span></div>
                        <div class="col-md-6 fw-bold">Uniform Bottom: <span
                                class="fw-light">{{ $appointment->bottom ?? 'N/A' }}</span></div>
                    </div>
                </div>
            </div>

            @if ($appointment->topMeasurement)
                <div class="card mb-4 shadow-lg border-0 rounded-3">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h5 class="card-title mb-0">Top Measurement Details</h5>
                    </div>
                    <div class="card-body p-4">
                        
                        @if ($appointment->top === 'Vest')
                            @include('admin.appointment.top-measurement.vest')
                        @endif

                        @if ($appointment->top === 'Polo')
                            @include('admin.appointment.top-measurement.polo')
                        @endif
                        @if ($appointment->top === 'Blazer')
                            @include('admin.appointment.top-measurement.blazer')
                        @endif
                        @if ($appointment->top === 'Blouse')
                            @include('admin.appointment.top-measurement.blouse')
                        @endif


                    </div>
                </div>
            @endif
            @if ($appointment->bottomMeasurement)
                <div class="card mb-4 shadow-lg border-0 rounded-3">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h5 class="card-title mb-0">Bottom Measurement Details</h5>
                    </div>
                    <div class="card-body p-4">
                       @if ($appointment->bottom === 'Pants')
                            @include('admin.appointment.bottom-measurement.pants')
                        @endif
                       @if ($appointment->bottom === 'Short')
                            @include('admin.appointment.bottom-measurement.short')
                        @endif
                       @if ($appointment->bottom === 'Skirt')
                            @include('admin.appointment.bottom-measurement.skirt')
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- /.card -->
    </div>
    <!-- /.col -->
    </div>
@endsection

@push('scripts')
@endpush
