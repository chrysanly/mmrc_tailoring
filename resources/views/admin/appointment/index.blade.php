@extends('layouts.admin.app')

@section('title', 'Appointments')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Appointments</h3>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>User Email</th>
                            <th>Appointment Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->user->name }}</td>
                            <td>{{ $appointment->user->email }}</td>
                            <td>{{ $appointment->date }}</td>
                            <td class="text-center">
                                @if ($appointment->status === 'pending')
                                <span class="badge rounded-pill text-bg-secondary">{{ $appointment->status }}</span>
                                @elseif ($appointment->status === 'approved')
                                <span class="badge rounded-pill text-bg-success">{{ $appointment->status }}</span>
                                @else
                                <span class="badge rounded-pill text-bg-danger">{{ $appointment->status }}</span>
                                @endif
                            </td>
                            <td width="10%">
                                <form action="{{ route('admin.appointment.update-status', [
                                'appointment' => $appointment->id]) }}" method="POST" style="display:inline-block;">
                                @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="approved" id="">
                                    <button type="submit" class="btn btn-sm btn-primary {{ $appointment->status !== 'pending' ? 'disabled' : '' }}">Approve</button>
                                </form>
                                <form action="{{ route('admin.appointment.update-status', [
                                'appointment' => $appointment->id]) }}" method="POST" style="display:inline-block;">
                                @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="rejected" id="">
                                    <button type="submit" class="btn btn-sm btn-danger {{ $appointment->status !== 'pending' ? 'disabled' : '' }}">Reject</button>
                                </form>
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
@endsection