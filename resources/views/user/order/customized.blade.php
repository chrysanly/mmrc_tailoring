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

    #set-of-uniform, #set-of-uniform-with-vest, #set-of-uniform-with-blazer, #upload-type{
        display: none;
    }
  
</style>
@endpush

@push('scripts')
<script>
    const checkUploadFile = document.getElementById('checkUploadFile');
    const formUniformType = document.getElementById('uniform-type');
    const formUploadType = document.getElementById('upload-type');
    const formType = document.getElementById('form_type');
    checkUploadFile.addEventListener('change', function(){
        if(this.checked){
            formUniformType.style.display = 'none';
            formUploadType.style.display = 'block';
            formType.value = 'true';
        }else{
            formUniformType.style.display = 'block';
            formUploadType.style.display = 'none';
            formType.value = 'false';
        }
    });


    function checkValue()
    {
        if(formType.value === 'true'){
            checkUploadFile.checked = true;
        } else {
            checkUploadFile.checked = false;
        }
    }

    function checkBehavior()
    {
        if(checkUploadFile.checked){
            formUniformType.style.display = 'none';
            formUploadType.style.display = 'block';
            formType.value = 'true';
        } else {
            formUniformType.style.display = 'block';
            formUploadType.style.display = 'none';
            formType.value = 'false';
        }
    }
    
    checkValue();
    checkBehavior();

    const uniformTop = document.getElementById('top');
    const uniformBottom = document.getElementById('bottom');
    const uniformSet = document.getElementById('set');
    const setUniform = document.getElementById('set-of-uniform');
    const setUniformWithVest = document.getElementById('set-of-uniform-with-vest');
    const setUniformWithBlazer = document.getElementById('set-of-uniform-with-blazer');
    
    uniformTop.addEventListener('change', function () {
        console.log(this.value);
        
    })

    uniformBottom.addEventListener('change', function () {
        console.log(this.value);
        
    })

    uniformSet.addEventListener('change', function () {
        console.log(this.value);

        
        if (this.value === 'set-1') {
           uniformValuesAndState('polo', 'pants');
           setUniformWithVest.style.display = 'none';
           setUniformWithBlazer.style.display = 'none';
            setUniform.style.display = 'block';

        }
        if (this.value === 'set-2') {
           uniformValuesAndState('vest', 'short');
           setUniform.style.display = 'none';
           setUniformWithBlazer.style.display = 'none';
           setUniformWithVest.style.display = 'block';
        }
        if (this.value === 'set-3') {
           uniformValuesAndState('blazer', 'skirt');
           setUniform.style.display = 'none';
           setUniformWithVest.style.display = 'none';
           setUniformWithBlazer.style.display = 'block';
        }

        if (this.value === '') {
            setUniform.style.display = 'none';
            setUniformWithVest.style.display = 'none';
            setUniformWithBlazer.style.display = 'none';
            uniformTop.disabled = false;
            uniformBottom.disabled = false;
            uniformTop.value = '';
            uniformBottom.value = '';
        }
        
    })

    function uniformValuesAndState(top, bottom)
    {
        uniformTop.value = top;
        uniformBottom.value = bottom;
        uniformTop.disabled = true;
        uniformBottom.disabled = true;
    }
    
</script>
@endpush

<x-layouts.user.app title="Order">

    <section id="make-order">
        <div class="container py-5">
            <h1 class="text-center fw-bold">Make an Customized Order</h1>

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

                <div class="d-flex justify-content-around gap-2 align-items-start">
                    <div class="d-flex flex-column gap-3 col-8">
                        <div class="card">
                            <div class="card-header">
                                <h5>Guide on how to measure yourself</h5>
                            </div>
                            <div class="card-body">

                                <div class="d-flex justify-content-around gap-4">
                                    <img src="{{ asset('assets/images/pants.png') }}" width="150" height="150"
                                        alt="pants-measure">
                                    <img src="{{ asset('assets/images/polo.webp') }}" width="150" height="150"
                                        alt="polo-measure">
                                </div>
                            </div>
                        </div>
                        <div class="card" id="uniform-type">
                            <div class="card-header">
                                <h5>Uniform Type</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <x-user.select name="set" title="Select Uniform Set">
                                        <option value="set-1">Set of Uniform</option>
                                        <option value="set-2">Set of Uniform with Vest</option>
                                        <option value="set-3">Set of Uniform with Blazer</option>
                                    </x-user.select>
                                    <x-user.select name="school" title="Select School">
                                        <option value="WMSU">WMSU</option>
                                        <option value="ZPPSU">ZPPSU</option>
                                        <option value="SOUTHERN">SOUTHERN</option>
                                    </x-user.select>
                                </div>
                                <div class="row">
                                    <x-user.select name="top" title="Select Uniform Top">
                                        <option value="polo">Polo</option>
                                        <option value="blouse">Blouse</option>
                                        <option value="vest">Vest</option>
                                        <option value="blazer">Blazer</option>
                                    </x-user.select>
                                    <x-user.select name="bottom" title="Select Uniform Bottom">
                                        <option value="short">Short</option>
                                        <option value="pants">Pants</option>
                                        <option value="skirt">Skirt</option>
                                    </x-user.select>

                                </div>
                            </div>
                        </div>
                        <div class="card" id="upload-type">
                            <div class="card-header">
                                <h5>Choose File</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Default file input example</label>
                                    <input class="form-control" type="file" name="file" id="formFile">
                                </div>
                            </div>
                        </div>
                        
                        @include('user.order.uniform_set')
                        @include('user.order.uniform_with_vest_set')
                        @include('user.order.uniform_with_blazer_set')

                        <button type="submit" class="btn btn-primary">Submit Order</button>
                    </div>
                    @include('user.order.uniform_prices')
                </div>
            </form>

        </div>
    </section>

</x-layouts.user.app>