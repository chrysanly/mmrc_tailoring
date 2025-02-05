@props(['title' => '', 'body' => '', 'icon' => ''])

<h5 class="mb-4">{{ $title }}</h5>
<div class="d-flex justify-content-between mb-4">
    <div class="homepage-icon">
        {{ $icon }}
    </div>
    <p>{{ $body }}</p>
</div>