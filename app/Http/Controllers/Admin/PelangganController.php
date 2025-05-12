<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Log;
use App\Models\Transaksi; // <- Tambahkan baris ini
use App\Http\Controllers\Controller;


class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggan = Pelanggan::latest()->paginate(10);
        return view('admin.pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        return view('admin.pelanggan.create', [
            'jenisLayananOptions' => [
                'Internet' => 'Internet',
                'VPN Voucher' => 'VPN Voucher'
            ]
        ]);
    }


    public function store(Request $request)
    {

        $request->validate([
            'nama' => 'required',
            'no_telepon' => 'required',
            'jenis_layanan' => 'required|in:Internet,VPN Voucher',
            'harga' => 'required|numeric|min:0',
            'jatuh_tempo' => 'required|date',
        ]);

        try {
            // Mengambil harga dari input dan memastikan formatnya benar
            $harga = floatval($request->harga);
            // Simpan data pelanggan
            $pelanggan = Pelanggan::create([
                'kode_pelanggan' => 'PLG_' . rand(10000, 99999),
                'nama' => $request->nama,
                'no_telepon' => $request->no_telepon,
                'jenis_layanan' => $request->jenis_layanan,
                'harga' => $harga,
                'jatuh_tempo' => $request->jatuh_tempo, // tetap disimpan di tabel pelanggan


            ]);

            // Simpan transaksi tagihan
            Transaksi::create([
                'kode_transaksi' => 'TRX_' . rand(10000, 99999),
                'pelanggan_id' => $pelanggan->id,
                'jenis' => 'tagihan',
                'status' => 'pending',
                'total' => $request->harga,
                'tanggal' => now(),
            ]);

            return redirect()->route('admin.pelanggan.index')->with('success', 'Pelanggan dan transaksi berhasil ditambahkan');
        } catch (\Exception $e) {
            \Log::error('Error tambah pelanggan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data'
            ], 500);
        }
    }
    private function generateKodePelanggan()
    {
        $prefix = 'PLG_';
        $randomNumber = mt_rand(10000, 99999); // Angka acak 5 digit
        return $prefix . $randomNumber;
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // PelangganController.php
    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id); // Pastikan model Pelanggan di-import
        $jenisLayananOptions = [
            'Internet' => 'Internet',
            'VPN Voucher' => 'VPN Voucher'
        ];

        return view('admin.pelanggan.edit', compact('pelanggan', 'jenisLayananOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'no_telepon' => 'required',
            'jenis_layanan' => 'required',
            'harga' => 'required|numeric',
            'jatuh_tempo' => 'required|date'
        ]);

        $pelanggan->update($validated);

        return redirect()->route('admin.pelanggan.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        // Hapus semua transaksi milik pelanggan ini
        $pelanggan->transaksi()->delete();

        // Hapus pelanggan
        $pelanggan->delete();

        return redirect()->route('admin.pelanggan.index')->with('success', 'Pelanggan dan transaksinya berhasil dihapus');
    }
}
