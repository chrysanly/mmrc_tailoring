@props(['type' => 'text', 'label' => '', 'name' => '', 'value' => '', 'required' => false])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <input type="{{ $type }}" class="form-control" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}"
        placeholder="" @if($required) required @endif>
    @error($name)
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>