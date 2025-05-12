@extends('layouts.app')

@section('title', 'Laporan Harian')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Harian</h6>
            <form method="GET" class="form-inline">
                <div class="input-group">
                    <input type="date" name="tanggal" class="form-control"
                        value="{{ request('tanggal', now()->format('Y-m-d')) }}"
                        max="{{ now()->format('Y-m-d') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksi as $key => $trx)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $trx->kode_transaksi }}</td>
                            <td>{{ $trx->pelanggan->nama }}</td>
                            <td>{{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}</td>
                            <td class="text-right">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge 
                                    @if($trx->status == 'lunas') badge-success
                                    @elseif($trx->status == 'pending') badge-warning
                                    @else badge-danger
                                    @endif">
                                    {{ ucfirst($trx->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada transaksi pada tanggal ini</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="font-weight-bold">
                            <td colspan="4" class="text-right">Total:</td>
                            <td class="text-right">Rp {{ number_format($transaksi->sum('total'), 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Summary Cards -->
            <div class="row mt-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Transaksi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $transaksi->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-receipt-cutoff fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Transaksi Lunas</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $transaksi->where('status', 'lunas')->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pending</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $transaksi->where('status', 'pending')->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-hourglass-split fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Dibatalkan</div>
                                    <div class="h5 mb-0 font-weight-bold text-dark">
                                        {{ $transaksi->where('status', 'batal')->count() }}
                                    </div>

                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-x-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table thead th {
        vertical-align: middle;
        white-space: nowrap;
    }

    .table td,
    .table th {
        padding: 0.75rem;
        vertical-align: middle;
    }

    .badge {
        font-size: 0.85em;
        font-weight: 500;
        padding: 0.35em 0.65em;
        color: #fff;
        /* Warna teks di dalam badge */
        background-color: #007bff;
        /* Ganti sesuai kebutuhan */
    }


    .text-dark {
        color: #343a40 !important;
        /* Warna gelap lebih dominan */
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto submit form saat tanggal berubah
    document.querySelector('input[name="tanggal"]').addEventListener('change', function() {
        this.closest('form').submit();
    });
</script>
@endpush