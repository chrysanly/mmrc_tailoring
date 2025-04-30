@extends('layouts.admin.app')

@section('title', 'Appointments')

@push('scripts')
    <script src="{{ asset('assets/admin/js/appointment.js') }}"></script>
    <script>
        const getAvailableTimeByDate = "{{ route('admin.appointment.get-available-time-by-date') }}";
    </script>
@endpush

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
                'id' => 'pick-up',
                'name' => 'Pick Up',
                'route' => route('admin.appointment.index', [
                    'status' => 'pick-up',
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
                                            @if (request('status') === 'completed' || request('status') === 'all')
                                                <th>Date Completed</th>
                                            @endif
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
                                                <td>{{ $appointment->time ?? '-' }}</td>

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
                                                    @elseif ($appointment->status === 'pick-up')
                                                        <span class="badge rounded-pill text-bg-success">Pick Up</span>
                                                    @elseif ($appointment->status === 'cancelled')
                                                        <span class="badge rounded-pill text-bg-danger">Cancelled</span>
                                                    @endif
                                                </td>
                                                @if (request('status') === 'completed' || request('status') === 'all')
                                                    <th>{{ $appointment->completed_at ?? '-' }}</th>
                                                @endif

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
                                                                    <li>
                                                                        <a class="dropdown-item" href="{{ route('admin.appointment.get-measurement', $appointment) }}">Edit Measurement</a>
                                                                    </li>
                                                                @endif
                                                                @if ($appointment->status === 'done')
                                                                    <x-admin.appointment-update-status :id="$appointment->id"
                                                                        status="pick-up" button="Move to Pick Up" />
                                                                    </li>
                                                                @endif
                                                                @if ($appointment->status === 'pick-up')
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
    @include('admin.appointment.reschedule_modal')
    @include('admin.appointment.cancel_appointment_modal')

@endsection
