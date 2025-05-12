@extends('layouts.admin')

@section('title', 'Tambah Pelanggan Baru')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Form Tambah Pelanggan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.pelanggan.store') }}" method="POST" id="pelangganForm">
            @csrf

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Pelanggan</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>

            <div class="mb-3">
                <label for="no_telepon" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
            </div>

            <div class="mb-3">
                <label for="jenis_layanan" class="form-label">Jenis Layanan</label>
                <select class="form-select" id="jenis_layanan" name="jenis_layanan" required>
                    <option value="">Pilih Jenis Layanan</option>
                    @foreach($jenisLayananOptions as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label">Harga Langganan (Rp)</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" id="harga" name="harga" min="0" step="1000" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="jatuh_tempo" class="form-label">Jatuh Tempo</label>
                <input type="date" class="form-control" id="jatuh_tempo" name="jatuh_tempo" required>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary me-2">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Set tanggal default jatuh tempo ke hari ini
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('jatuh_tempo').value = today;
    });

    // Form submission dengan SweetAlert
    document.getElementById('pelangganForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);

        // Validasi manual jika diperlukan
        if (!formData.get('nama') || !formData.get('no_telepon') ||
            !formData.get('jenis_layanan') || !formData.get('harga') ||
            !formData.get('jatuh_tempo')) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Harap isi semua field yang diperlukan!'
            });
            return;
        }

        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah Anda yakin ingin menambahkan pelanggan baru?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form secara manual
                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses!',
                                text: data.message || 'Pelanggan berhasil ditambahkan',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = "{{ route('admin.pelanggan.index') }}";
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message || 'Terjadi kesalahan saat menyimpan data'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan teknis'
                        });
                        console.error('Error:', error);
                    });
            }
        });
    });
</script>
@endpush