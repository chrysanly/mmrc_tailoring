@extends('layouts.admin.app')

@section('title', 'Settings')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Payment Options</div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Account Number</th>
                            <th>Account Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div id="pagination"></div>
                
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="alert alert-success d-none" role="alert">
            <span id="alert-message">{{ session('success') }}</span>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Create Payment Option</div>
            </div>
            <div class="card-body">
                <form id="payment-option-form" action="{{ route('admin.settings.payment-option.store') }}">
                    <x-admin.input-field label="Name" name="name" />
                    <x-admin.input-field label="Account Number" name="account_number" />
                    <x-admin.input-field label="Account Name" name="account_name"/>
                    <div class="d-flex gap-2">
                        <a class="btn btn-secondary w-100 mt-2" id="clear-button">Cancel</a>
                        <button type="button" id="submitButton" class="btn btn-primary w-100 mt-2">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/admin/js/payment_option.js') }}"></script>
@endpush