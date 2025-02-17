@push('scripts')
    <script>
        const checkUploadFile = document.getElementById('checkUploadFile');
        const formUniformType = document.getElementById('uniform-type');
        const formUploadType = document.getElementById('upload-type');
        const formType = document.getElementById('form_type');

        const uniformTop = document.getElementById('top');
        const uniformBottom = document.getElementById('bottom');
        const uniformSet = document.getElementById('set');

        const hiddenTop = document.getElementById('hiddenTop');
        const hiddenBottom = document.getElementById('hiddenBottom');

        if (checkUploadFile) {
            checkUploadFile.addEventListener('change', function() {

                if (this.checked) {
                    formUniformType.style.display = 'none';
                    formUploadType.style.display = 'block';
                    formType.value = 'true';
                    uniformValuesAndState('', '');
                    uniformTop.disabled = false;
                    uniformBottom.disabled = false;
                } else {
                    formUniformType.style.display = 'block';
                    formUploadType.style.display = 'none';
                    formType.value = 'false';
                }
            });
        }

        uniformTop.addEventListener('change', function() {
            hiddenTop.value = this.value;
        })

        uniformBottom.addEventListener('change', function() {
            hiddenBottom.value = this.value;
        })

        uniformSet.addEventListener('change', function() {
            console.log(this.value);

            if (this.value === '' || this.value === 'custom') {
                uniformValuesAndState('', '');
                uniformTop.disabled = false;
                uniformBottom.disabled = false;
            } else {
                uniformTop.disabled = true;
                uniformBottom.disabled = true;

                if (this.value === 'set-1') {
                    uniformValuesAndState("polo", "pants");
                }
                if (this.value === 'set-2') {
                    uniformValuesAndState("vest", "short");
                }
                if (this.value === 'set-3') {
                    uniformValuesAndState("blazer", "skirt");
                }
            }

        })

        function uniformValuesAndState(top, bottom) {
            uniformTop.value = top;
            uniformBottom.value = bottom;

            // Sync hidden fields so Laravel receives the values
            hiddenTop.value = top;
            hiddenBottom.value = bottom;
        }

        function checkValue() {
            if (formType.value === 'true') {
                checkUploadFile.checked = true;
            } else {
                checkUploadFile.checked = false;
            }
        }

        function checkBehavior() {


            if (checkUploadFile.checked) {
                formUniformType.style.display = 'none';
                formUploadType.style.display = 'block';
                formType.value = 'true';

            } else {
                formUniformType.style.display = 'block';
                formUploadType.style.display = 'none';
                formType.value = 'false';
            }
        }

        if (checkUploadFile) {
            checkValue();
            checkBehavior();
        }
    </script>
@endpush

<div class="card" id="uniform-type">
    <div class="card-header">
        <h5>Uniform Type</h5>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center gap-2">
            <div class="d-flex flex-column gap-3 w-100">
                <x-user.select name="set" title="Select Uniform Set" col="col-12">
                    <option value="custom" {{ old('set') === 'custom' ? 'selected' : '' }}>Custom
                    </option>
                    <option value="set-1" {{ old('set') === 'set-1' ? 'selected' : '' }}>Set of
                        Uniform</option>
                    <option value="set-2" {{ old('set') === 'set-2' ? 'selected' : '' }}>Set of
                        Uniform with Vest</option>
                    <option value="set-3" {{ old('set') === 'set-3' ? 'selected' : '' }}>Set of
                        Uniform with Blazer</option>
                </x-user.select>
                <x-user.select name="top" title="Select Uniform Top" col="col-12">
                    <option value="polo" {{ old('top') === 'polo' ? 'selected' : '' }}>Polo
                    </option>
                    <option value="blouse" {{ old('top') === 'blouse' ? 'selected' : '' }}>Blouse
                    </option>
                    <option value="vest" {{ old('top') === 'vest' ? 'selected' : '' }}>Vest
                    </option>
                    <option value="blazer" {{ old('top') === 'blazer' ? 'selected' : '' }}>Blazer
                    </option>
                </x-user.select>
                <x-user.select name="bottom" title="Select Uniform Bottom" col="col-12">
                    <option value="short" {{ old('bottom') === 'short' ? 'selected' : '' }}>Short
                    </option>
                    <option value="pants" {{ old('bottom') === 'pants' ? 'selected' : '' }}>Pants
                    </option>
                    <option value="skirt" {{ old('bottom') === 'skirt' ? 'selected' : '' }}>Skirt
                    </option>
                </x-user.select>
            </div>
            <div class="d-flex flex-column gap-3 w-100">
                <div class="col-6 w-100">
                    <input type="text" class="form-control" name="quantity" value="{{ old('quantity') }}"
                    placeholder="Quantity">
                @error('quantity')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                </div>
                <x-user.select name="school" title="Select School" col="col-12">
                    <option value="WMSU" {{ old('school') === 'WMSU' ? 'selected' : '' }}>WMSU
                    </option>
                    <option value="ZPPSU" {{ old('school') === 'ZPPSU' ? 'selected' : '' }}>ZPPSU
                    </option>
                    <option value="SOUTHERN" {{ old('school') === 'SOUTHERN' ? 'selected' : '' }}>
                        SOUTHERN</option>
                </x-user.select>
                <x-user.select name="size" title="Select Size" col="col-12">
                    <option value="small" {{ old('size') === 'small' ? 'selected' : '' }}>small
                    </option>
                    <option value="medium" {{ old('size') === 'medium' ? 'selected' : '' }}>medium
                    </option>
                    <option value="large" {{ old('size') === 'large' ? 'selected' : '' }}>large
                    </option>
                    <option value="extra large" {{ old('size') === 'extra large' ? 'selected' : '' }}>extra large
                    </option>

                </x-user.select>
            </div>
        </div>
    </div>
</div>
