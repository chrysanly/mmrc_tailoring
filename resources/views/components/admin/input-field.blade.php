@props(['type' => 'text', 'label' => '', 'name' => '', 'value' => '', 'required' => false, 'attrs' => []])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <input type="{{ $type }}" class="form-control" name="{{ $name }}" id="{{ $name }}" 
    value="{{ old($name, $value)}}" 
    placeholder="" 
    @if($required) required @endif @forelse ($attrs as $key => $item)
        {{ $key }}="{{ $item }}"
    @empty
        
    @endforelse>
    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>