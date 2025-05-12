<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | App-Billing</title> <!-- Ganti dengan nama aplikasi Anda -->

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .bg-dark-blue {
            background-color: rgb(6, 56, 109);
        }

        .nav-pills .nav-link.active {
            background-color: rgb(5, 13, 29);
        }

        .nav-pills .nav-link:hover {
            background-color: #1b263b;
        }

        /* Sidebar Responsive */
        #sidebar {
            transition: transform 0.3s ease;
            width: 250px;
            height: 100vh;
            position: fixed;
            z-index: 1000;
        }

        #main-content {
            margin-left: 250px;
            /* Sesuaikan dengan lebar sidebar */
            transition: margin 0.3s ease;
            width: calc(100% - 250px);
        }

        /* Mobile Styles */
        @media (max-width: 991.98px) {
            #sidebar {
                transform: translateX(-100%);
            }

            #sidebar.show {
                transform: translateX(0);
            }

            #main-content {
                margin-left: 0;
                width: 100%;
            }

            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
                display: none;
            }
        }

        /* Di dalam @media mobile (max-width: 991.98px) */
        .header-admin {
            padding-top: 60px !important;
            /* Sesuaikan dengan tinggi tombol toggle */
        }

        #sidebarToggle {
            top: 15px;
            left: 15px;
            z-index: 1001;
            /* Pastikan lebih rendah dari sidebar */
        }

        /* Animasi dan efek hover */
        .nav-pills .nav-link {
            transition: all 0.3s ease;
            border-radius: 4px;
            margin-bottom: 2px;
        }

        .nav-pills .nav-link.active {
            background-color: rgba(5, 13, 29, 0.8) !important;
            font-weight: 500;
        }

        .nav-pills .nav-link:hover:not(.active) {
            background-color: rgba(27, 38, 59, 0.5);
        }

        /* Sub-menu (jika ada) */
        .sub-menu {
            padding-left: 1.5rem;
            list-style: none;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .nav-item:hover .sub-menu {
            max-height: 200px;
        }
    </style>
    @stack('styles') <!-- Untuk CSS tambahan per halaman -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
    <!-- Sidebar Overlay (Mobile Only) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->

    <nav id="sidebar" class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark-blue" style="width: 250px; height: 100vh;">
        <!-- Header Sidebar -->
        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 text-white text-decoration-none">
            <i class="bi bi-currency-exchange fs-4 me-2"></i>
            <span class="fs-4">Billing System</span>
        </a>
        <hr>

        <!-- Menu Items -->
        <ul class="nav nav-pills flex-column mb-auto">
            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link text-white @if(request()->routeIs('admin.dashboard')) active @endif">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>

            <!-- Pelanggan -->
            <li class="nav-item has-submenu">
                <a href="#pelanggan-submenu" class="nav-link text-white @if(request()->routeIs('admin.pelanggan.*')) active @endif"
                    data-bs-toggle="collapse">
                    <i class="bi bi-people-fill me-2"></i> Pelanggan
                    <i class="bi bi-chevron-down float-end"></i>
                </a>
                <ul class="submenu collapse @if(request()->routeIs('admin.pelanggan.*')) show @endif" id="pelanggan-submenu">
                    <li>
                        <a href="{{ route('admin.pelanggan.index') }}"
                            class="nav-link text-white @if(request()->routeIs('admin.pelanggan.index')) active @endif">
                            <i class="bi bi-list-ul me-2"></i> Daftar Pelanggan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.pelanggan.create') }}"
                            class="nav-link text-white @if(request()->routeIs('admin.pelanggan.create')) active @endif">
                            <i class="bi bi-plus-circle me-2"></i> Add Pelanggan
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Transaksi -->
            <li class="nav-item has-submenu">
                <a href="#transaksi-submenu" class="nav-link text-white @if(request()->routeIs('admin.transaksi.*')) active @endif"
                    data-bs-toggle="collapse">
                    <i class="bi bi-cash-stack me-2"></i> Transaksi
                    <i class="bi bi-chevron-down float-end"></i>
                </a>
                <ul class="submenu collapse @if(request()->routeIs('admin.transaksi.*')) show @endif" id="transaksi-submenu">
                    <li>
                        <a href="{{ route('admin.transaksi.index') }}"
                            class="nav-link text-white @if(request()->routeIs('admin.transaksi.index')) active @endif">
                            <i class="bi bi-credit-card me-2"></i> List Transaksi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.transaksi.pembayaran') }}"
                            class="nav-link text-white @if(request()->routeIs('admin.transaksi.pembayaran')) active @endif">
                            <i class="bi bi-credit-card me-2"></i> Pembayaran
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.transaksi.tagihan') }}"
                            class="nav-link text-white @if(request()->routeIs('admin.transaksi.tagihan')) active @endif">
                            <i class="bi bi-receipt me-2"></i> Tagihan
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Laporan -->
            <li class="nav-item has-submenu">
                <a href="#laporan-submenu" class="nav-link text-white @if(request()->routeIs('admin.laporan.*')) active @endif"
                    data-bs-toggle="collapse">
                    <i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan
                    <i class="bi bi-chevron-down float-end"></i>
                </a>
                <ul class="submenu collapse @if(request()->routeIs('admin.laporan.*')) show @endif" id="laporan-submenu">
                    <li>
                        <a href="{{ route('admin.laporan.harian') }}"
                            class="nav-link text-white @if(request()->routeIs('admin.laporan.harian')) active @endif">
                            <i class="bi bi-calendar-day me-2"></i> Harian
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.laporan.bulanan') }}"
                            class="nav-link text-white @if(request()->routeIs('admin.laporan.bulanan')) active @endif">
                            <i class="bi bi-calendar-month me-2"></i> Bulanan
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Pengaturan -->
            <li class="nav-item has-submenu">
                <a href="#pengaturan-submenu" class="nav-link text-white @if(request()->routeIs('admin.pengaturan.*')) active @endif"
                    data-bs-toggle="collapse">
                    <i class="bi bi-gear me-2"></i> Pengaturan
                    <i class="bi bi-chevron-down float-end"></i>
                </a>
                <ul class="submenu collapse @if(request()->routeIs('admin.pengaturan.*')) show @endif" id="pengaturan-submenu">
                    <li>
                        <a href="{{ url('admin/pengaturan') }}"

                            class="nav-link text-white @if(request()->routeIs('admin.pengaturan.index')) active @endif">
                            <i class="bi bi-sliders me-2"></i> Umum
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.pengaturan.pengingat-tagihan.index') }}"
                            class="nav-link text-white @if(request()->routeIs('admin.pengaturan.pengingat-tagihan.index')) active @endif">
                            <i class="bi bi-bell me-2"></i> Pengingat Tagihan
                        </a>
                    </li>
                </ul>
            </li>

        </ul>

        <!-- Logout -->
        <hr>
        <div class="mt-auto">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-danger w-100" type="submit">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- File: resources/views/layouts/app.blade.php -->
    <div id="main-content">
        <!-- Header dengan toggle button -->
        <div class="header-admin d-flex align-items-center px-4 py-3 bg-white shadow-sm">
            <button id="sidebarToggle" class="btn btn-primary d-lg-none me-3">
                <i class="bi bi-list"></i>
            </button>
            <h1 class="mb-0">@yield('title', 'Menu')</h1>
        </div>

        <!-- Konten utama -->
        <div class="p-4">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            // Toggle Sidebar
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                sidebarOverlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
            });

            // Tutup sidebar saat klik overlay
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                sidebarOverlay.style.display = 'none';
            });

            // Auto-close sidebar saat resize (jika lebar layar > 992px)
            window.addEventListener('resize', function() {
                if (window.innerWidth > 992) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.style.display = 'none';
                }
            });
        });
        document.getElementById('toggleSidebarButton').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');

            // Sesuaikan margin konten utama
            const mainContent = document.getElementById('main-content');
            if (sidebar.classList.contains('show')) {
                mainContent.style.marginLeft = '250px';
            } else {
                mainContent.style.marginLeft = '0';
            }
        });
    </script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>

</html>