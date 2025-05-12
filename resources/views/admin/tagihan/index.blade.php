@extends('layouts.admin')

@section('title', 'Tagihan Pending')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header">
            <h5>Tagihan Pending</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode Transaksi</th>
                        <th>Nama Pelanggan</th>
                        <th>Total</th>
                        <th>Tanggal Jatuh Tempo</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Di dalam tagihan.blade.php -->
                    @foreach($tagihan as $trx)
                    <tr>
                        <td>{{ $trx->kode_transaksi }}</td>
                        <td>{{ $trx->pelanggan->nama }}</td>
                        <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($trx->jatuh_tempo)->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{ route('admin.transaksi.sendWhatsAppTagihan', $trx->id) }}"
                                class="btn btn-sm btn-primary" target="_blank">
                                Kirim Tagihan via WhatsApp
                            </a>


                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection