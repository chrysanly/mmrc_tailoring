@extends('layouts.user.app')

@section('title', 'Appointment')

@section('content')
    <section id="appointment-history" class="mb-5">
        <div class="container py-5">
            <h1 class="text-center fw-bold">My Appointments</h1>
           
            <ul class="col-md-8 col-12 list-group mt-4 gap-2 mx-auto">
                @forelse ($appointments as $appointment)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-3">
                            <div class="d-flex flex-column">
                                <span class="fw-bold">Date</span>
                                <span>{{ $appointment->date }}</span>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="fw-bold">Time</span>
                                {{ \Carbon\Carbon::parse($appointment->time_from)->format('g:i A') .
                                    ' - ' .
                                    \Carbon\Carbon::parse($appointment->time_to)->format('g:i A') }}
                            </div>
                        </div>
                        <div class="d-flex flex-column text-end">
                            @if ($appointment->status === 'pending')
                            <span class="badge text-bg-secondary rounded-pill">{{ ucwords(str_replace('-', ' ', $appointment->status)) }}</span>
                            @elseif($appointment->status === 'in-progress')

                            <span class="badge rounded-pill text-bg-warning">
                                                            In Progress - <span
                                                                class="{{ $appointment->topMeasurement || $appointment->bottomMeasurement ? 'text-success' : 'text-danger' }}">({{ $appointment->topMeasurement || $appointment->bottomMeasurement ? 'measured' : 'pending measurement' }})</span>
                                                        </span>
                            @elseif($appointment->status === 'done')
                            <span class="badge text-bg-info rounded-pill">{{ ucwords(str_replace('-', ' ', $appointment->status)) }}</span>
                            @elseif($appointment->status === 'completed')
                            <span class="badge text-bg-success rounded-pill">{{ ucwords(str_replace('-', ' ', $appointment->status)) }}</span>
                            @elseif($appointment->status === 'no-show')
                            <span class="badge text-bg-danger rounded-pill">{{ ucwords(str_replace('-', ' ', $appointment->status)) }}</span>
                            @endif
                        </div>
                    </li>
                @empty
                 <div class="d-flex justify-content-center align-items-center text-black fw-bold" style="height: 50vh"
                    role="alert">
                   No Appointments Found
                </div>
                @endforelse
            </ul>

            @if (!$appointments->isEmpty())
                <div class="d-flex justify-content-between mt-4">
                    @if ($appointments->onFirstPage())
                        <span class="btn btn-secondary disabled">Previous</span>
                    @else
                        <a href="{{ $appointments->previousPageUrl() }}" class="btn btn-primary">Previous</a>
                    @endif

                    @if ($appointments->hasMorePages())
                        <a href="{{ $appointments->nextPageUrl() }}" class="btn btn-primary">Next</a>
                    @else
                        <span class="btn btn-secondary disabled">Next</span>
                    @endif
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
    <style>
        #appointment-history {
            height: 75vh;
        }
    </style>
@endpush

@push('scripts')
@endpush
