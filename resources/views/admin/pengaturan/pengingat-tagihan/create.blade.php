@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-4">Tambah Pengingat Tagihan</h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.pengaturan.pengingat-tagihan.store') }}" method="POST">
                @include('admin.pengaturan.pengingat-tagihan._form', [
                'pelangganList' => $pelangganList,
                'pengingat' => $pengingat
                ])

                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('admin.pengaturan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('
        success ') }}',
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif
@endsection