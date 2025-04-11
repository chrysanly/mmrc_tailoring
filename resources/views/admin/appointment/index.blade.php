@extends('layouts.admin.app')

@section('title', 'Appointments')

@section('content')

    @php
        $tabs = [
            [
                'id' => 'all',
                'name' => 'All',
                'route' => route('admin.appointment.index', [
                    'status' => 'all',
                ]),
            ],
            [
                'id' => 'pending',
                'name' => 'Pending',
                'route' => route('admin.appointment.index', [
                    'status' => 'pending',
                ]),
            ],
            [
                'id' => 'in-progress',
                'name' => 'In Progress',
                'route' => route('admin.appointment.index', [
                    'status' => 'in-progress',
                ]),
            ],
            [
                'id' => 'done',
                'name' => 'Done',
                'route' => route('admin.appointment.index', [
                    'status' => 'done',
                ]),
            ],
            [
                'id' => 'completed',
                'name' => 'Completed',
                'route' => route('admin.appointment.index', [
                    'status' => 'completed',
                ]),
            ],
            [
                'id' => 'cancelled',
                'name' => 'Cancelled',
                'route' => route('admin.appointment.index', [
                    'status' => 'cancelled',
                ]),
            ],
        ];
    @endphp

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        @foreach ($tabs as $item)
            <li class="nav-item" role="presentation">
                <a href="{{ $item['route'] }}" class="nav-link {{ request('status') === $item['id'] ? 'active' : '' }}"
                    id="{{ $item['id'] }}-tab" type="button" role="tab" aria-controls="{{ $item['id'] }}-tab-pane"
                    aria-selected="{{ $item['id'] === 'pending' ? 'true' : 'false' }}">{{ $item['name'] }}</a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content" id="myTabContent">
        @foreach ($tabs as $item)
            <div class="tab-pane fade {{ $item['id'] === request('status') ? 'show active' : '' }}"
                id="{{ $item['id'] }}-tab-pane" role="tabpanel" aria-labelledby="{{ $item['id'] }}-tab" tabindex="0">
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Appointments</h3>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="5">#</th>
                                            <th>User Name</th>
                                            <th>User Email</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                            @if (request('status') === 'cancelled' || request('status') === 'all')
                                                <th>Remarks</th>
                                            @endif
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($appointments as $appointment)
                                            <tr>
                                                <td width="5">{{ $appointment->id }}</td>
                                                <td>{{ $appointment->user->fullname }}</td>
                                                <td>{{ $appointment->user->email }}</td>
                                                <td>{{ $appointment->date }}</td>
                                                <td>{{ $appointment->appointment_time }}</td>

                                                <td class="text-center">
                                                    @if ($appointment->status === 'pending')
                                                        <span class="badge rounded-pill text-bg-secondary">Pending</span>
                                                    @elseif ($appointment->status === 'in-progress')
                                                        <span class="badge rounded-pill text-bg-warning">
                                                            In Progress - <span
                                                                class="{{ $appointment->topMeasurement || $appointment->bottomMeasurement ? 'text-success' : 'text-danger' }}">({{ $appointment->topMeasurement || $appointment->bottomMeasurement ? 'measured' : 'pending measurement' }})</span>
                                                        </span>
                                                    @elseif ($appointment->status === 'done')
                                                        <span class="badge rounded-pill text-bg-info">Done</span>
                                                    @elseif ($appointment->status === 'completed')
                                                        <span class="badge rounded-pill text-bg-success">Completed</span>
                                                    @elseif ($appointment->status === 'cancelled')
                                                        <span class="badge rounded-pill text-bg-danger">Cancelled</span>
                                                    @endif
                                                </td>

                                                @if (request('status') === 'cancelled' || request('status') === 'all')
                                                    <td>{{ $appointment->cancelled_reason ?? 'N/A' }}</td>
                                                @endif

                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-danger btn-sm dropdown-toggle" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false"
                                                            {{ $appointment->status === 'no-show' || $appointment->status === 'cancelled' ? 'disabled' : '' }}>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            @if ($appointment->status === 'pending')
                                                                <li>
                                                                    <x-admin.appointment-update-status :id="$appointment->id"
                                                                        status="in-progress" button="Move to In Progress" />
                                                                    <button type="button" class="dropdown-item"
                                                                        onclick="openModal('cancelModal', {{ $appointment->id }})">Cancel</button>
                                                                    <button type="button" class="dropdown-item"
                                                                        onclick="openModal('recheduleModal', {{ $appointment->id }})">Reschedule</button>
                                                                </li>
                                                            @endif
                                                            @if ($appointment->topMeasurement || $appointment->bottomMeasurement)
                                                                @if ($appointment->status === 'in-progress')
                                                                    <li>
                                                                        <x-admin.appointment-update-status :id="$appointment->id"
                                                                            status="done" button="Move to Done" />
                                                                    </li>
                                                                @endif
                                                                @if ($appointment->status === 'done')
                                                                    <x-admin.appointment-update-status :id="$appointment->id"
                                                                        status="completed" button="Move to Complete" />
                                                                    </li>
                                                                @endif

                                                                @if ($appointment->status !== 'completed' && $appointment->status !== 'cancelled')
                                                                    <li>
                                                                        <hr class="dropdown-divider">
                                                                    </li>
                                                                @endif
                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('admin.appointment.view-measurement', $appointment->id) }}"
                                                                        target="_blank">View
                                                                        Measurement</a></li>
                                                            @endif
                                                            @if ($appointment->status === 'in-progress' && !$appointment->topMeasurement && !$appointment->bottomMeasurement)
                                                                <li>
                                                                    <a href="{{ route('admin.appointment.get-measurement', $appointment->id) }}"
                                                                        class="dropdown-item">Get
                                                                        Measurement</a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-4">
                                    {{ $appointments->links() }}
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div class="modal fade" id="recheduleModal" tabindex="-1" aria-labelledby="recheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="recheduleModalLabel">Reschedule</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <x-admin.input-field label="Date" type="date" name="dateInput" />
                    <x-admin.input-field label="Time From" type="time" name="fromInput" />
                    <x-admin.input-field label="Time To" type="time" name="toInput" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitResched">Resched</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="cancelModalLabel">Cancel Appointment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Reason:</label>
                        <textarea class="form-control" id="reason" placeholder="Reason for cancellation of appointment"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitCancel">Cancel</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        let selectedId = null;
        let modalElement;
        let bsModal;

        function openModal(modalId, id) {
            selectedId = id;
            modalElement = document.getElementById(modalId);
            if (modalElement) {
                bsModal = new bootstrap.Modal(modalElement);
                bsModal.show();
            } else {
                console.error("Modal with ID " + modalId + " not found.");
            }
        }

        $("#submitResched").click(function() {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, resched it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    submitAppointment(selectedId);
                }
            });
        });

        $("#submitCancel").click(function() {
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

        const submitAppointment = async (id) => {
            const url = "appointment/resched/" + id;
            const formData = new FormData();
            formData.append('date', $("#dateInput").val());
            formData.append('time_from', $("#fromInput").val());
            formData.append('time_to', $("#toInput").val());

            // Debugging: Check formData contents
            // formData.forEach((value, key) => console.log(key, value));

            try {
                await fetchRequest(url, 'patch', formData);
               location.reload();
            } catch (error) {
                console.error("Error resched appointment:", error);
            }
        };

        const cancelAppointment = async (id) => {
            const url = "appointment/cancel/" + id;

            const formData = new FormData();
            formData.append("reason", $("#reason").val());
            try {
                await fetchRequest(url, 'patch', formData);
                $("#cancelModal").modal('hide');
                setTimeout(() => {
                    location.reload();
                }, 3000);
            } catch (error) {
                console.error("Error cancelling appointment:", error);
            }
        }
    </script>
@endpush
