@props(['title' => '', 'icon' => ''])

<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon bi bi-speedometer"></i>
        <p>
            {{ $title }}
            <i class="nav-arrow bi bi-chevron-right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
       {{ $slot }}
    </ul>
</li>