@extends('layouts.admin.app')

@section('title', 'Appointments')

@section('content')

    <div class="row">
        <div class="col-md-8 mx-auto">
            <h3>Get Measurement</h3>

            <div>
                <form action="{{ route('admin.appointment.store-measurement', $appointment) }}" method="POST">
                    @csrf
                    <x-uniform-type />
                    <div class="d-flex gap-2 justify-content-between mt-2">
                        @include('user.order.measurements_field')
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-2">Submit Order</button>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@endsection

@push('scripts')
@endpush
