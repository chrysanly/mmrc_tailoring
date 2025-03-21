@props(['name' => '', 'title' => '', 'col' => 'col-6'])

<div class="{{ $col }} mb-3">
    <select class="form-select text-capitalize" name="{{ $name }}" id="{{ $name }}" aria-label="Default select example">
        <option value="" selected>{{ $title }}</option>
       {{ $slot }}
    </select>
    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>