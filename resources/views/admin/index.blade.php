@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Dashboard</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <p>Welcome {{ auth()->user()->fullname }}.</p>
                </div>

                <div class="container-fluid">
                    <h4 class="text-danger fw-bold">Appointment Counts</h4>
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <h3>{{ $pendingAppointments }}</h3>

                                    <p>Pending Appointments</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('admin.appointment.index', ['status' => 'pending']) }}"
                                    class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $inProgressAppointments }}</h3>

                                    <p>In Progress Appointments</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('admin.appointment.index', ['status' => 'in-progress']) }}"
                                    class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3>{{ $doneAppointments }}</h3>

                                    <p>Done Appointments</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('admin.appointment.index', ['status' => 'done']) }}"
                                    class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $completedAppointments }}</h3>

                                    <p>Completed Appointments</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('admin.appointment.index', ['status' => 'completed']) }}"
                                    class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>

                    {{-- Order Counts --}}
                    <h4 class="text-danger fw-bold">Order Counts</h4>
                    <div class="row mb-4">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <h3>{{ $pendingOrders }}</h3>

                                    <p>Pending Orders</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('admin.appointment.index', ['status' => 'pending']) }}"
                                    class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $inProgressOrders }}</h3>

                                    <p>In Progress Orders</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('admin.appointment.index', ['status' => 'in-progress']) }}"
                                    class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3>{{ $doneOrders }}</h3>

                                    <p>Done Orders</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('admin.appointment.index', ['status' => 'done']) }}"
                                    class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $completedOrders }}</h3>

                                    <p>Completed Orders</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('admin.appointment.index', ['status' => 'completed']) }}"
                                    class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>

                    {{-- Latest Appointments --}}
                    <div class="card mb-4">
                        <div class="card-header border-transparent">
                            <h3 class="card-title text-danger fw-bold">5 Latest Appointments</h3>

                            <div class="card-tools">
                                <a href="{{ route('admin.appointment.index', [
                        'status' => 'pending']) }}" class="btn btn-tool" data-card-widget="collapse">
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
                        'status' => 'pending']) }}" class="btn btn-tool" data-card-widget="collapse">
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
