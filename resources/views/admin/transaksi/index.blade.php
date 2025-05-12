@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header">
            <h5>Daftar Transaksi</h5>
        </div>
        <div class="card-body">

            <form method="GET" action="{{ route('admin.transaksi.index') }}" class="mb-3 row">
                <div class="col-md-4">
                    <label for="jenis_layanan" class="form-label">Filter Jenis Layanan</label>
                    <select name="jenis_layanan" id="jenis_layanan" class="form-select">
                        <option value="">-- Semua Layanan --</option>
                        <option value="internet" {{ request('jenis_layanan') == 'internet' ? 'selected' : '' }}>Internet</option>
                        <option value="vpn voucher" {{ request('jenis_layanan') == 'vpn voucher' ? 'selected' : '' }}>VPN</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>




            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Jenis Layanan</th>
                        <th>Kode Transaksi</th>
                        <th>Nama Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksi as $trx)
                    <tr>
                        <td>{{ ucfirst($trx->pelanggan->jenis_layanan ?? '-') }}</td>
                        <td>{{ $trx->kode_transaksi }}</td>
                        <td>{{ $trx->pelanggan->nama ?? '-' }}</td>
                        <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $trx->status === 'pending' ? 'warning' : 'success' }} fs-6 text-white">
                                {{ ucfirst($trx->status) }}
                            </span>
                        </td>
                        <td>
                            @if ($trx->status === 'pending')
                            <form action="{{ route('admin.transaksi.konfirmasi', $trx->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-check-circle"></i> Konfirmasi
                                </button>
                            </form>
                            @else
                            <button class="btn btn-sm btn-secondary" disabled>
                                <i class="fas fa-check-circle"></i> Aman
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Konfirmasi sebelum submit
    document.querySelectorAll('form[action*="konfirmasi"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Transaksi',
                text: "Anda akan mengirim pesan WhatsApp ke pelanggan",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Kirim',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // SweetAlert notifikasi sukses + redirect ke WhatsApp
    @if(session('success') && session('whatsapp_link'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('
        success ') }}',
        timer: 2000,
        showConfirmButton: false
    });

    setTimeout(() => {
        window.open("{{ session('whatsapp_link') }}", "_blank");
    }, 2200);
    @endif
</script>
@endpush