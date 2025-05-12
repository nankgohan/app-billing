<nav id="sidebar" class="d-flex flex-column flex-shrink-0 p-3 text-white bg-admin" style="width: 250px; min-height: 100vh;">
    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 text-white text-decoration-none">
        <i class="bi bi-shield-lock me-2"></i>
        <span class="fs-4">Admin Panel</span>
    </a>
    <hr>

    <ul class="nav nav-pills flex-column mb-auto">
        <x-menu-item route="admin.dashboard" icon="speedometer2" label="Dashboard" />
        <x-menu-item route="admin.customers.index" icon="people-fill" label="Pelanggan" badge="New" />
        <x-menu-item route="payment.rekap" icon="receipt" label="Rekap Pembayaran" />
        <x-menu-item route="rekap.bulanan" icon="calendar-month" label="Laporan Bulanan" />
        <x-menu-item route="whatsapp.index" icon="whatsapp" label="WhatsApp" />
    </ul>

    <hr>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger w-100">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </button>
    </form>
</nav>