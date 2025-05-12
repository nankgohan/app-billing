@extends('layouts.admin')

@section('title', 'Daftar Pelanggan')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Daftar Pelanggan</h5>
            <a href="{{ route('admin.pelanggan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Pelanggan
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Jenis Layanan</th>
                            <th>Harga</th>
                            <th>Jatuh Tempo</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pelanggan as $plg)
                        <tr>
                            <td>{{ $plg->kode_pelanggan }}</td>
                            <td>{{ $plg->nama }}</td>
                            <td>{{ $plg->no_telepon }}</td>
                            <td>{{ $plg->jenis_layanan }}</td>
                            <td>Rp {{ number_format($plg->harga, 0, ',', '.') }}</td>
                            <td>{{ $plg->jatuh_tempo ? \Carbon\Carbon::parse($plg->jatuh_tempo)->format('d-m-Y') : '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.pelanggan.edit', $plg->id) }}"
                                    class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('admin.pelanggan.destroy', $plg->id) }}"
                                    method="POST" class="d-inline"
                                    onsubmit="event.preventDefault(); confirmDelete(this);">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $pelanggan->links() }}
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Notifikasi sukses
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('
        success ') }}',
        timer: 2000,
        showConfirmButton: false
    });
    @endif

    // Konfirmasi hapus
    function confirmDelete(form) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endpush
@endsection