@props(['name' => '', 'title' => '', 'col' => 'col-6'])

<div class="{{ $col }}">
    <select class="form-select" name="{{ $name }}" id="{{ $name }}" aria-label="Default select example">
        <option value="" selected>{{ $title }}</option>
       {{ $slot }}
    </select>
</div>