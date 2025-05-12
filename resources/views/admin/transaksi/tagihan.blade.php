@extends('layouts.app')

@section('title', 'Manajemen Tagihan')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Tagihan</h6>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr class="bg-light">
                            <th>No</th>
                            <th>Kode Tagihan</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tagihan as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->kode_transaksi }}</td>
                            <td>{{ $item->pelanggan->nama ?? '-' }}</td>
                            <td class="text-right">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                            <td>{{ $item->jatuh_tempo ? $item->jatuh_tempo->format('d/m/Y') : '-' }}</td>
                            <td>
                                <span class="badge 
                                    {{ $item->status == 'lunas' ? 'badge-success' : 'badge-warning' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.transaksi.show', $item->id) }}" class="btn btn-sm btn-circle btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data tagihan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($tagihan->hasPages())
            <div class="mt-4">
                {{ $tagihan->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table td,
    .table th {
        vertical-align: middle;
    }

    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
    }
</style>
@endpush