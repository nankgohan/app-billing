@extends('layouts.app')

@section('title', 'Laporan Bulanan')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5>Laporan Bulanan</h5>
                <form method="GET" class="form-inline">
                    <input type="month" name="bulan" class="form-control"
                        value="{{ $bulan }}" onchange="this.form.submit()">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jumlah Transaksi</th>
                            <th>Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $total = $transaksi->sum('total');
                        @endphp
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($bulan)->format('F Y') }}</td>
                            <td>{{ $transaksi->count() }}</td>
                            <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection