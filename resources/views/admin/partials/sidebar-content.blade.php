<div class="d-flex flex-column h-100 p-3">
    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 text-white text-decoration-none">
        <i class="bi bi-speedometer2 me-2"></i>
        <span class="fs-4">Admin Panel</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link text-white @if(request()->is('admin/dashboard')) active @endif">
                <i class="bi bi-house-door me-2"></i> Dashboard
            </a>
        </li>
        <!-- Menu lainnya -->
    </ul>
    <hr>
    <div class="mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger w-100" type="submit">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
        </form>
    </div>
</div>