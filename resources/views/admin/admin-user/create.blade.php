@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Admin Users</h3>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('admin.admin-users.store') }}" method="POST">
                        @csrf
                          <x-admin.input-field name="first_name" type="text" label="First Name" />
                          <x-admin.input-field name="last_name" type="text" label="Last Name" />
                          <x-admin.input-field name="middle_name" type="text" label="Middle Name" />
                          <x-admin.input-field name="email" type="email" label="Email" />

                          <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.admin-users.index') }}" class="btn btn-secondary">Cancel</a>
                          <button type="submit" class="btn btn-primary">Save</button>
                          </div>
                    </form>
                </div>

            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection
