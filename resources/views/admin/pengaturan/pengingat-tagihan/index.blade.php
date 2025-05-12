@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-4">Pengingat Tagihan</h4>

    {{-- TOMBOL TAMBAH --}}
    <a href="{{ route('admin.pengaturan.pengingat-tagihan.create') }}" class="btn btn-success mb-3">+ Tambah Pengingat</a>

    {{-- TABEL --}}
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Pelanggan</th> {{-- Added pelanggan column --}}
                        <th>Status</th>
                        <th>Hari Sebelum</th>
                        <th>Waktu Kirim</th>
                        <th>Template Pesan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengingatList ?? [] as $index => $item) {{-- Changed variable name and added null safety --}}
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        {{-- NAMA PELANGGAN --}}
                        <td>
                            {{ $item->pelanggan->nama ?? 'Pelanggan Tidak Ditemukan' }}
                            @if(!$item->pelanggan)
                            <span class="text-danger small">(ID: {{ $item->pelanggan_id }})</span>
                            @endif
                        </td>

                        {{-- STATUS + TOGGLE --}}
                        <td>
                            <form action="{{ route('admin.pengaturan.pengingat-tagihan.toggle', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="btn btn-sm {{ $item->status === 'aktif' ? 'btn-success' : 'btn-secondary' }}">
                                    {{ ucfirst($item->status) }}
                                </button>
                            </form>
                        </td>

                        <td>{{ $item->hari_sebelum }} hari sebelum</td>
                        <td>{{ ucfirst($item->waktu_kirim) }} ({{ waktuJam($item->waktu_kirim) ?? 'N/A' }})</td> {{-- Added null safety --}}
                        <td>{{ Str::limit($item->template_pesan, 50) }}</td> {{-- Limited text length --}}

                        {{-- AKSI --}}
                        <td>
                            <a href="{{ route('admin.pengaturan.pengingat-tagihan.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>

                            <form action="{{ route('admin.pengaturan.pengingat-tagihan.destroy', $item->id) }}" method="POST"
                                class="d-inline form-hapus">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada data pengingat tagihan</td> {{-- Updated colspan --}}
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent {{-- Added to preserve parent scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        {
            {
                --Added DOMContentLoaded--
            }
        }
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('
            success ') }}',
            timer: 2000,
            showConfirmButton: false
        });
        @endif

        // KONFIRMASI HAPUS
        document.querySelectorAll('.form-hapus').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Data?',
                    text: "Data akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    });
</script>
@endsection