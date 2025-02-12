@props(['title' => '', 'icon' => '', 'active' => false])

<li class="nav-item {{ $active ? 'menu-open' : '' }}">
    <a href="#" class="nav-link">
        {{ $icon }}
        <p>
            {{ $title }}
            <i class="nav-arrow bi bi-chevron-right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
       {{ $slot }}
    </ul>
</li>