@extends('layouts.admin.app')

@section('title', 'Dashboard')

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="{{ asset('assets/admin/js/dashboard/sale-report.js') }}"></script>
    <script src="{{ asset('assets/admin/js/dashboard/pie-chart-data.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/dashboard.css') }}">

    <style>
        @media (max-width: 780px) {
            #weekNavigation {
            position: relative;
            margin-top: 120px;
            width: 100%;
            text-align: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Dashboard</h3>
                </div>
                <!-- /.card-header -->
                <div class="container-fluid">
                    {{-- Pie Chart --}}
                    <div class="d-md-flex d-sm-inline justify-content-between align-items-center p-2 gap-2">
                        <x-admin.pie-chart-count title="Appointment Counts" pieChartId="appointmentPieChart" col="col-md-4"/>
                        <x-admin.pie-chart-count title="Order Status Counts" pieChartId="orderStatusPieChart" col="col-md-4"/>
                        <x-admin.pie-chart-count title="Order Counts" pieChartId="orderPieChart" col="col-md-4"/>
                    </div>

                    <h4>Order Sales Report</h4>
                    {{-- Sale Report --}}
                    <div class="card mb-4 p-2">
                        <div class="row mb-5">
                            <div class="col-md-4">
                                <label for="year" class="form-label">Select Year</label>
                                <select id="year" class="form-select" onchange="updateYearRange()">
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="year" class="form-label">Select Range</label>
                                <!-- Range Selection Dropdown -->
                                <select id="rangeType" class="form-select" onchange="updateChartRange()">
                                    <option value="weekly" selected>Weekly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="today">Today</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <!-- Week Navigation Buttons -->
                                <div id="weekNavigation" class="col-sm-4" style="position: absolute; top: 40px;">
                                        <button id="prevRangeBtn" class="btn btn-secondary btn-sm"> &lt; </button>
                                        <span id="rangeText" class="fw-bold">April 6 - April 12</span>
                                        <button id="nextRangeBtn" class="btn btn-secondary btn-sm"> &gt; </button>
                                </div>

                                <!-- Date Range Picker -->
                                <div id="dateRangeContainer" style="display: none;">
                                    <label for="dateRangePicker" class="form-label">Select Date Range</label>
                                    <input type="text" id="dateRangePicker" class="form-control" />
                                </div>
                            </div>
                        </div>

                        <canvas id="lineChart" width="400" height="100"></canvas>
                    </div>
                    {{-- Sale Report --}}

                    {{-- Latest Appointments --}}
                    <div class="card mb-4">
                        <div class="card-header border-transparent">
                            <h3 class="card-title text-danger fw-bold">5 Latest Appointments</h3>

                            <div class="card-tools">
                                <a href="{{ route('admin.appointment.index', [
                                    'status' => 'pending',
                                ]) }}"
                                    class="btn btn-tool" data-card-widget="collapse">
                                    View more
                                </a>

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Emal</th>
                                            <th>Appointment Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($appointments as $appointment)
                                            <tr>
                                                <td>{{ $appointment->user->fullname }}</td>
                                                <td>{{ $appointment->user->email }}</td>
                                                <td>{{ $appointment->date }}</td>
                                                <td>
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
                                                    @else
                                                        <span class="badge rounded-pill text-bg-danger">No Show</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td>No Data</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>

                        <!-- /.card-footer -->
                    </div>
                    {{-- Latest Order --}}
                    <div class="card mb-4">
                        <div class="card-header border-transparent">
                            <h3 class="card-title text-danger fw-bold">5 Latest Orders</h3>

                            <div class="card-tools">
                                <a href="{{ route('admin.order.index', [
                                    'status' => 'pending',
                                ]) }}"
                                    class="btn btn-tool" data-card-widget="collapse">
                                    View more
                                </a>

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Order Type</th>
                                            <th>Payment Status</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $order->user->fullname }}</td>
                                                <td>{{ $order->order_type }}</td>
                                                <td>{{ $order->payment_status }}</td>
                                                <td>
                                                    @if ($order->status === 'pending')
                                                        <span class="badge rounded-pill text-bg-secondary">Pending</span>
                                                    @elseif ($order->status === 'in-progress')
                                                        <span class="badge rounded-pill text-bg-info">In Progress</span>
                                                    @elseif ($order->status === 'done')
                                                        <span class="badge rounded-pill text-bg-primary">Done</span>
                                                    @else
                                                        <span class="badge rounded-pill text-bg-success">Completed</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>

                        <!-- /.card-footer -->
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection
