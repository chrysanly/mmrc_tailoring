@extends('layouts.admin.app')

@section('title', 'Settings')

@section('content')
<div class="row">
    <div class="col-md-6 mx-auto">
       
        @session('success')
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endsession
        <div class="card">
            <div class="card-header">
                <div class="card-title">Appointment Max Limit</div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.appointment-limit.store') }}" method="post">
                    @csrf
                    <x-admin.input-field label="Appointment Limit (Per Day)" name="limit" value="{{ $limit }}" />
                    <button type="submit" class="btn btn-primary w-100 mt-2">Save</button>
                </form>
            </div>
        </div>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection