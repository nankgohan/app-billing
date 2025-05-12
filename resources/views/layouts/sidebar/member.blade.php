<nav id="sidebar" class="d-flex flex-column flex-shrink-0 p-3 text-white bg-member" style="width: 250px; min-height: 100vh;">
    <a href="{{ route('member.dashboard') }}" class="d-flex align-items-center mb-3 text-white text-decoration-none">
        <i class="bi bi-person-circle me-2"></i>
        <span class="fs-4">Member Area</span>
    </a>
    <hr>

    <ul class="nav nav-pills flex-column mb-auto">
        <x-menu-item route="member.dashboard" icon="house-door" label="Beranda" />
        <x-menu-item route="member.billing" icon="credit-card" label="Tagihan" />
        <x-menu-item route="member.history" icon="clock-history" label="Riwayat" />
        <x-menu-item route="member.profile" icon="person-lines-fill" label="Profil" />
    </ul>
    <hr>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-light w-100">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </button>
    </form>
</nav>