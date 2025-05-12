@props([
'route' => '',
'icon' => '',
'label' => '',
'badge' => null,
'badgeColor' => 'primary'
])

<li class="nav-item">
    <a
        href="{{ route($route) }}"
        class="nav-link text-white {{ request()->routeIs($route) ? 'active bg-dark' : '' }}">
        <i class="bi bi-{{ $icon }} me-2"></i>
        {{ $label }}

        @if($badge)
        <span class="badge bg-{{ $badgeColor }} float-end">{{ $badge }}</span>
        @endif
    </a>
</li>