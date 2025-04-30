@push('scripts')
    <script>
        const checkUploadFile = document.getElementById('checkUploadFile');
        const formUniformType = document.getElementById('uniform-type');
        const formUploadType = document.getElementById('upload-type');
        const formType = document.getElementById('form_type');


        const poloMeasurement = document.getElementById('polo-measurement');
        const pantsMeasurement = document.getElementById('pants-measurement');
        const vestMeasurement = document.getElementById('vest-measurement');
        const shortMeasurement = document.getElementById('short-measurement');
        const blazerMeasurement = document.getElementById('blazer-measurement');
        const skirtMeasurement = document.getElementById('skirt-measurement');
        const blouseMeasurement = document.getElementById('blouse-measurement');

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
                selectedBottom("");
                selectedTop("");
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
            selectedTop(this.value);
            hiddenTop.value = this.value;
        })

        uniformBottom.addEventListener('change', function() {
            hiddenBottom.value = this.value;
            selectedBottom(this.value);
        })

        uniformSet.addEventListener('change', function() {
            selectedSet(this.value);

        })


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

        function showTop() {
            const top = uniformTop.value;
            selectedTop(top);
        }

        function showBottom() {
            const bottom = uniformBottom.value;
            selectedBottom(bottom);
        }

        function showSet() {

            const set = uniformSet.value;

            selectedSet(set);
        }



        function uniformValuesAndState(top, bottom) {
            uniformTop.value = top;
            uniformBottom.value = bottom;

            // Sync hidden fields so Laravel receives the values
            hiddenTop.value = top;
            hiddenBottom.value = bottom;
        }

        function selectedTop(top) {
            switch (top) {
                case 'polo':
                    poloMeasurement.classList.remove('d-none');
                    vestMeasurement.classList.add('d-none');
                    blazerMeasurement.classList.add('d-none');
                    blouseMeasurement.classList.add('d-none');
                    break;
                case 'vest':
                    vestMeasurement.classList.remove('d-none');
                    poloMeasurement.classList.add('d-none');
                    blazerMeasurement.classList.add('d-none');
                    blouseMeasurement.classList.add('d-none');

                    break;
                case 'blazer':
                    vestMeasurement.classList.add('d-none');
                    poloMeasurement.classList.add('d-none');
                    blouseMeasurement.classList.add('d-none');
                    blazerMeasurement.classList.remove('d-none');
                    break;
                case 'blouse':
                    vestMeasurement.classList.add('d-none');
                    poloMeasurement.classList.add('d-none');
                    blazerMeasurement.classList.add('d-none');
                    blouseMeasurement.classList.remove('d-none');
                    break;
                case '':
                    vestMeasurement.classList.add('d-none');
                    poloMeasurement.classList.add('d-none');
                    blazerMeasurement.classList.add('d-none');
                    break;
            }
        }

        function selectedBottom(bottom) {
            switch (bottom) {
                case 'short':
                    shortMeasurement.classList.remove('d-none');
                    pantsMeasurement.classList.add('d-none');
                    skirtMeasurement.classList.add('d-none');
                    break;
                case 'pants':
                    shortMeasurement.classList.add('d-none');
                    pantsMeasurement.classList.remove('d-none');
                    skirtMeasurement.classList.add('d-none');
                    break;
                case 'skirt':
                    shortMeasurement.classList.add('d-none');
                    pantsMeasurement.classList.add('d-none');
                    skirtMeasurement.classList.remove('d-none');
                    break;
                case '':
                    shortMeasurement.classList.add('d-none');
                    pantsMeasurement.classList.add('d-none');
                    skirtMeasurement.classList.add('d-none');
                    break;
            }
        }

        function selectedSet(set) {
            if (set === '' || set === 'custom') {
                uniformValuesAndState('', '');
                uniformTop.disabled = false;
                uniformBottom.disabled = false;
                selectedTop("");
                selectedBottom("");
            } else {
                uniformTop.disabled = true;
                uniformBottom.disabled = true;

                if (set === 'set-1') {
                    uniformValuesAndState("polo", "pants");
                    selectedTop("polo");
                    selectedBottom("pants");
                }
                if (set === 'set-2') {
                    uniformValuesAndState("vest", "short");
                    selectedTop("vest");
                    selectedBottom("short");
                }
                if (set === 'set-3') {
                    uniformValuesAndState("blazer", "skirt");
                    selectedTop("blazer");
                    selectedBottom("skirt");
                }
            }
        }
       if (checkUploadFile) {
         checkValue();
         checkBehavior();
       }

        if (uniformSet.value === "custom" && uniformTop.value !== "") {
            showTop();
        }
        if (uniformSet.value === "custom" && uniformBottom.value !== "") {
            showBottom();
        }

        if (uniformSet.value !== "" && uniformSet.value !== "custom") {
            showSet();
        }
    </script>
@endpush

<div class="card" id="uniform-type">
    <div class="card-header">
        <h5>Uniform Type</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <x-user.select name="set" title="Select Uniform Set">
                <option value="custom" {{ old('set') === 'custom' ? 'selected' : '' }}>Custom
                </option>
                <option value="set-1" {{ old('set') === 'set-1' ? 'selected' : '' }}>Set of
                    Uniform</option>
                <option value="set-2" {{ old('set') === 'set-2' ? 'selected' : '' }}>Set of
                    Uniform with Vest</option>
                <option value="set-3" {{ old('set') === 'set-3' ? 'selected' : '' }}>Set of
                    Uniform with Blazer</option>
            </x-user.select>
            <x-user.select name="school" title="Select School">
                <option value="WMSU" {{ old('school') === 'WMSU' ? 'selected' : '' }}>WMSU
                </option>
                <option value="ZPPSU" {{ old('school') === 'ZPPSU' ? 'selected' : '' }}>ZPPSU
                </option>
                <option value="SOUTHERN" {{ old('school') === 'SOUTHERN' ? 'selected' : '' }}>
                    SOUTHERN</option>
            </x-user.select>
        </div>
        <div class="row">
            <x-user.select name="top" title="Select Uniform Top">
                <option value="polo" {{ old('top') === 'polo' ? 'selected' : '' }}>Polo
                </option>
                <option value="blouse" {{ old('top') === 'blouse' ? 'selected' : '' }}>Blouse
                </option>
                <option value="vest" {{ old('top') === 'vest' ? 'selected' : '' }}>Vest
                </option>
                <option value="blazer" {{ old('top') === 'blazer' ? 'selected' : '' }}>Blazer
                </option>
            </x-user.select>
            <x-user.select name="bottom" title="Select Uniform Bottom">
                <option value="short" {{ old('bottom') === 'short' ? 'selected' : '' }}>Short
                </option>
                <option value="pants" {{ old('bottom') === 'pants' ? 'selected' : '' }}>Pants
                </option>
                <option value="skirt" {{ old('bottom') === 'skirt' ? 'selected' : '' }}>Skirt
                </option>
            </x-user.select>

        </div>
    </div>
</div>
