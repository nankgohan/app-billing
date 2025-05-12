@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-4">Pengaturan Umum</h4>

    {{-- TOMBOL PENGINGAT TAGIHAN --}}
    <a href="{{ route('admin.pengaturan.pengingat-tagihan.index') }}" class="btn btn-info mb-3">Pengaturan Pengingat Tagihan</a>

    {{-- TOMBOL PENGATURAN LAINNYA --}}
    <a href="{{ route('admin.pengaturan.other-setting') }}" class="btn btn-info mb-3">Pengaturan Lainnya</a>
</div>
@endsection