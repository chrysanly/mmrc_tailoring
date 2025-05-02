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
                                {{ $appointment->time }}
                            </div>
                        </div>
                        <div class="d-flex flex-column text-end">
                            @if ($appointment->status === 'pending')
                                <span
                                    class="badge text-bg-secondary rounded-pill">{{ ucwords(str_replace('-', ' ', $appointment->status)) }}</span>
                            @elseif($appointment->status === 'in-progress')
                                <span class="badge rounded-pill text-bg-warning">
                                    In Progress - <span
                                        class="{{ $appointment->topMeasurement || $appointment->bottomMeasurement ? 'text-success' : 'text-danger' }}">({{ $appointment->topMeasurement || $appointment->bottomMeasurement ? 'measured' : 'pending measurement' }})</span>
                                </span>
                            @elseif($appointment->status === 'done')
                                <span
                                    class="badge text-bg-info rounded-pill">{{ ucwords(str_replace('-', ' ', $appointment->status)) }}</span>
                            @elseif($appointment->status === 'completed')
                                <span
                                    class="badge text-bg-success rounded-pill">{{ ucwords(str_replace('-', ' ', $appointment->status)) }}</span>
                            @elseif($appointment->status === 'no-show')
                                <span
                                    class="badge text-bg-danger rounded-pill">{{ ucwords(str_replace('-', ' ', $appointment->status)) }}</span>
                            @elseif($appointment->status === 'pick-up')
                                <span
                                    class="badge text-bg-warning rounded-pill">{{ ucwords(str_replace('-', ' ', $appointment->status)) }}</span>
                            @else
                                <span class="badge text-bg-danger rounded-pill">Cancelled</span>
                            @endif
                        </div>
                        @if ($appointment->status === 'pending')
                            <button class="btn btn-danger btn-sm"
                                onclick="openModal({{ $appointment->id }})">Cancel</button>
                        @endif
                        @if($appointment->status === 'cancelled')
                            <div class="w-25 " >
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-end">Reason</span>
                                    <span class="text-end text-truncate" style="overflow: hidden; white-space: nowrap;">
                                        {{ $appointment->cancelled_reason }}
                                    </span>
                                </div>
                            </div>
                        @endif
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

    <div class="modal fade" id="cancelAppointmentModal" tabindex="-1" aria-labelledby="cancelAppointmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="cancelAppointmentModalLabel">Cancel Appointment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Reason:</label>
                        <textarea class="form-control" id="reason" placeholder="Reason for cancellation of appointment"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="confirmCancelAppointment">Confirm</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        #appointment-history {
            height: 75vh;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $("#cancelAppointment").click(function() {
            $("#cancelAppointmentModal").modal("show");
        });

        let selectedId;
        const openModal = (id) => {
            selectedId = id;
            $("#cancelAppointmentModal").modal("show");
        }

        $("#confirmCancelAppointment").click(function() {

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

        const cancelAppointment = async (id) => {
            const url = `/user/appointment/cancel/${id}`;

            const formData = new FormData();
            formData.append("reason", $("#reason").val());
            formData.append("reasontest", 'qweqwe');
            try {
                await fetchRequest(url, 'PUT', formData);
                $("#cancelAppointmentModal").modal('hide');
                setTimeout(() => {
                    location.reload();
                }, 3000);
            } catch (error) {
                console.error("Error submitting appointment:", error);
            }
        }
    </script>
@endpush
