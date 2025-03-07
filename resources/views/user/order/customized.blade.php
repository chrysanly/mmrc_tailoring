@push('styles')
    <style>
        .card-header {
            color: var(--white-color);
            background-color: var(--dark-color);
        }

        .form-check-input {
            border: 1px solid var(--dark-color);
        }

        .form-check-input:checked {
            background-color: var(--red-color);
            border-color: var(--red-color);
        }

        .alert-danger1 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        #set-of-uniform,
        #set-of-uniform-with-vest,
        #set-of-uniform-with-blazer,
        #upload-type {
            display: none;
        }
    </style>
@endpush

<x-layouts.user.app title="Order">

    <section id="make-order">
        <div class="container py-5">
            <h1 class="text-center fw-bold">Make an Customized Order</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="mb-4" action="{{ route('user.order.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-check py-3">
                    <input class="form-check-input" type="checkbox" value="" id="checkUploadFile">
                    <label class="form-check-label fw-bold" for="checkUploadFile">
                        File upload for order ?
                    </label>
                </div>

                <input type="hidden" name="form_type" id="form_type" value="{{ old('form_type') }}">
                <input type="hidden" name="order_type" value="customized">

                <div class="d-flex justify-content-around gap-3 align-items-start">
                    <div class="d-flex flex-column gap-3 col-8">
                        <div class="card">
                            <div class="card-header">
                                <h5>Guide on how to measure yourself</h5>
                            </div>
                            <div class="card-body">

                                <div class="d-flex justify-content-around gap-4">
                                    <a href="{{ asset('assets/images/pants.png') }}" target="__blank">
                                        <img src="{{ asset('assets/images/pants.png') }}"  width="150" height="150"
                                            alt="pants-measure">
                                    </a>
                                    <img src="{{ asset('assets/images/polo.png') }}" width="150" height="150"
                                        alt="polo-measure">
                                </div>
                            </div>
                        </div>
                        <x-uniform-type />
                        <div class="card" id="upload-type">
                            <x-uniform-upload-order />
                        </div>

                        <div class="d-flex gap-2 justify-content-between">
                            @include('user.order.measurements_field')
                        </div>

                        <input type="hidden" name="top" id="hiddenTop" value="{{ old('top') }}">
                        <input type="hidden" name="bottom" id="hiddenBottom" value="{{ old('bottom') }}">

                        @include('user.order.additional-items')

                        <button type="submit" class="btn btn-primary">Submit Order</button>
                    </div>
                    @include('user.order.uniform_prices')
                </div>
            </form>

        </div>
    </section>

</x-layouts.user.app>
