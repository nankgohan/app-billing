@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('sidebar-menu')
<!-- Contoh menu tambahan spesifik untuk dashboard -->
<li class="nav-item">
    <a href="#" class="nav-link text-white">
        <i class="bi bi-calendar-check me-2"></i> Menu Contoh 1
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link text-white">
        <i class="bi bi-gear me-2"></i> Menu Contoh 2
    </a>
</li>
@endsection

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Selamat Datang Admin</h4>

    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Pengguna</h5>
                    <p class="card-text display-6">0</p> <!-- Data dinamis nanti -->
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Aktivitas Terbaru</h5>
                    <p>Belum ada aktivitas</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection