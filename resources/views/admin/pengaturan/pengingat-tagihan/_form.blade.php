@csrf
{{-- PELANGGAN --}}
<div class="mb-3">
    <label for="pelanggan_id" class="form-label">Pelanggan</label>
    <select name="pelanggan_id" id="pelanggan_id" class="form-select" required>
        <option value="">-- Pilih Pelanggan --</option>
        @foreach($pelangganList as $pelanggan)
        <option value="{{ $pelanggan->id }}" {{ old('pelanggan_id', $pelanggan->id) == $pelanggan->id ? 'selected' : '' }}>
            {{ $pelanggan->nama }}
        </option>
        @endforeach
    </select>
</div>

{{-- STATUS --}}
<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select name="status" id="status" class="form-select" required>
        <option value="aktif" {{ old('status', $pengingat->status ?? '') == 'aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ old('status', $pengingat->status ?? '') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
    </select>
</div>

{{-- HARI SEBELUM --}}
<div class="mb-3">
    <label for="hari_sebelum" class="form-label">Berapa hari sebelum jatuh tempo?</label>
    <input type="number" name="hari_sebelum" id="hari_sebelum" class="form-control" required
        value="{{ old('hari_sebelum', $pengingat->hari_sebelum ?? '') }}">
</div>

{{-- WAKTU KIRIM --}}
<div class="mb-3">
    <label for="waktu_kirim" class="form-label">Waktu Kirim</label>
    <select name="waktu_kirim" id="waktu_kirim" class="form-select" required>
        <option value="pagi" {{ old('waktu_kirim', $pengingat->waktu_kirim ?? '') == 'pagi' ? 'selected' : '' }}>Pagi</option>
        <option value="siang" {{ old('waktu_kirim', $pengingat->waktu_kirim ?? '') == 'siang' ? 'selected' : '' }}>Siang</option>
        <option value="malam" {{ old('waktu_kirim', $pengingat->waktu_kirim ?? '') == 'malam' ? 'selected' : '' }}>Malam</option>
    </select>
</div>

{{-- TEMPLATE PESAN --}}
<div class="mb-3">
    <label for="template_pesan" class="form-label">Template Pesan</label>
    <textarea name="template_pesan" id="template_pesan" class="form-control" rows="4" required>{{ old('template_pesan', $pengingat->template_pesan ?? '') }}</textarea>
    <div class="form-text">
        Gunakan placeholder seperti <code>{NAMA}</code>, <code>{JATUH_TEMPO}</code>, <code>{TAGIHAN}</code>
    </div>
</div>