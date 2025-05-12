@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Pengingat Tagihan</h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.pengaturan.update', $pengingat->id) }}" method="POST">
                @method('PUT')
                @include('admin.pengaturan._form')

                <button type="submit" class="btn btn-primary">Perbarui</button>
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