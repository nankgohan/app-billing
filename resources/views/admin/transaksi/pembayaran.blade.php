@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header">
            <h5>Daftar Pembayaran Pending</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode Transaksi</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi as $trx)
                    <tr>
                        <td>{{ $trx->kode_transaksi }}</td>
                        <td>{{ $trx->pelanggan->nama }}</td>
                        <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                        <td>
                            <button class="btn btn-sm btn-success">
                                <i class="bi bi-check-circle"></i> Konfirmasi
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection