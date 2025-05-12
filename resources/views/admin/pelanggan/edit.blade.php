@extends('layouts.admin')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Pelanggan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.pelanggan.update', $pelanggan->id) }}" method="POST" id="editPelangganForm">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Pelanggan</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $pelanggan->nama) }}" required>
            </div>

            <div class="mb-3">
                <label for="no_telepon" class="form-label">No Telepon</label>
                <input type="text" name="no_telepon" id="no_telepon" class="form-control" value="{{ old('no_telepon', $pelanggan->no_telepon) }}" required>
            </div>

            <div class="mb-3">
                <label for="jenis_layanan" class="form-label">Jenis Layanan</label>
                <select name="jenis_layanan" id="jenis_layanan" class="form-select" required>
                    @foreach($jenisLayananOptions as $value => $label)
                    <option value="{{ $value }}" {{ $pelanggan->jenis_layanan === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label">Harga Langganan (Rp)</label>
                <input type="number" name="harga" id="harga" class="form-control" value="{{ old('harga', $pelanggan->harga) }}" required>
            </div>

            <div class="mb-3">
                <label for="jatuh_tempo" class="form-label">Jatuh Tempo</label>
                <input type="date" name="jatuh_tempo" id="jatuh_tempo" class="form-control" value="{{ old('jatuh_tempo', $pelanggan->jatuh_tempo->format('Y-m-d')) }}" required>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('editPelangganForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);

        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah Anda yakin ingin mengubah data pelanggan ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Update',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-HTTP-Method-Override': 'PUT'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message || 'Data pelanggan berhasil diperbarui',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = "{{ route('admin.pelanggan.index') }}";
                            });
                        } else {
                            Swal.fire('Gagal', data.message || 'Terjadi kesalahan saat update.', 'error');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Gagal', 'Terjadi kesalahan pada server.', 'error');
                    });
            }
        });
    });
</script>
@endpush