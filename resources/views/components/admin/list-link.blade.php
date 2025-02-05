@props(['title' => '', 'icon' => '', 'link' => '#', 'active' => false])

<li class="nav-item">
    <a href="{{ $link }}" class="nav-link {{ $active ? 'active' : '' }}">
        {{ $icon }}
        <p>{{ $title }}</p>
    </a>
</li>