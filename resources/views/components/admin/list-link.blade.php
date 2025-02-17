@props(['title' => '', 'icon' => '', 'link' => '#', 'active' => false, 'hasCount' => false, 'count' => 0])

<li class="nav-item">
    <a href="{{ $link }}" class="nav-link {{ $active ? 'active' : '' }}">
        {{ $icon }}
       
       @if ($hasCount)
        <div class="d-flex gap-2">
            <p>{{ $title }}</p>
            <span class="badge text-bg-danger text-center">{{ $count }}</span>
        </div>
            @else
             <p>{{ $title }}</p>
       @endif
    </a>
</li>