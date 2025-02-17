@push('scripts')
    <script>
        uniformTop.addEventListener('change', function() {
            hiddenTop.value = this.value;
        })

        uniformBottom.addEventListener('change', function() {
            hiddenBottom.value = this.value;
        })
    </script>
@endpush

<div class="card-header">
    <h5>Choose File</h5>
</div>
<div class="card-body">
    <div class="row mb-4">
        <x-user.select name="file_school" title="Select School" col="col-4">
            <option value="WMSU" {{ old('file_school') === 'WMSU' ? 'selected' : '' }}>WMSU
            </option>
            <option value="ZPPSU" {{ old('file_school') === 'ZPPSU' ? 'selected' : '' }}>ZPPSU
            </option>
            <option value="SOUTHERN" {{ old('file_school') === 'SOUTHERN' ? 'selected' : '' }}>
                SOUTHERN</option>
        </x-user.select>
        <x-user.select name="file_top" title="Select Uniform Top" col="col-4">
            <option value="polo" {{ old('file_top') === 'polo' ? 'selected' : '' }}>Polo
            </option>
            <option value="blouse" {{ old('file_top') === 'blouse' ? 'selected' : '' }}>Blouse
            </option>
            <option value="vest" {{ old('file_top') === 'vest' ? 'selected' : '' }}>Vest
            </option>
            <option value="blazer" {{ old('file_top') === 'blazer' ? 'selected' : '' }}>Blazer
            </option>
        </x-user.select>
        <x-user.select name="file_bottom" title="Select Uniform Bottom" col="col-4">
            <option value="short" {{ old('file_bottom') === 'short' ? 'selected' : '' }}>Short
            </option>
            <option value="pants" {{ old('file_bottom') === 'pants' ? 'selected' : '' }}>Pants
            </option>
            <option value="skirt" {{ old('file_bottom') === 'skirt' ? 'selected' : '' }}>Skirt
            </option>
        </x-user.select>
    </div>
    <div class="d-flex gap-3 w-100">
        <div class="col-6">
            <input type="text" class="form-control w-100" name="file_quantity" id="file_quantity" value="{{ old('quantity') }}"
            placeholder="Quantity">
             @error('file_quantity')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
        </div>

        <x-user.select name="file_size" title="Select Size">
            <option value="small" {{ old('file_size') === 'small' ? 'selected' : '' }}>small
            </option>
            <option value="medium" {{ old('file_size') === 'medium' ? 'selected' : '' }}>medium
            </option>
            <option value="large" {{ old('file_size') === 'large' ? 'selected' : '' }}>large
            </option>
            <option value="extra large" {{ old('file_size') === 'extra large' ? 'selected' : '' }}>extra large
            </option>

        </x-user.select>
    </div>

    <div class="mt-3">
        <label for="formFile" class="form-label">Upload File</label>
        <input class="form-control" type="file" multiple name="file[]" id="formFile">
        @error('file.*')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        @error('file')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
