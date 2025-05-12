<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\PengingatTagihan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengingatTagihanController extends Controller
{
    // Tampilkan semua data pelanggan + pengingat (jika ada)
    public function index()
    {
        try {
            $pengingatList = PengingatTagihan::with(['pelanggan' => function ($query) {
                $query->select('id', 'kode_pelanggan', 'nama', 'jatuh_tempo');
            }])
                ->orderBy('created_at', 'desc')
                ->get();


            return view('admin.pengaturan.pengingat-tagihan.index', [
                'pengingatList' => $pengingatList,
                'errors' => session('errors'),
                'isEmpty' => $pengingatList->isEmpty() // Tambahkan flag untuk view
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in index: ' . $e->getMessage());
            return view('admin.pengaturan.pengingat-tagihan.index', [
                'pengingatList' => collect(),
                'errors' => session('errors'),
                'isEmpty' => true
            ]);
        }
    }


    // Tampilkan form edit pengingat pelanggan
    public function edit($id)
    {
        $pelanggan = Pelanggan::with('pengingatTagihan')->findOrFail($id);
        $pelangganList = Pelanggan::all();  // Menambahkan daftar semua pelanggan

        return view('admin.pengaturan.pengingat-tagihan._form', compact('pelanggan', 'pelangganList'));
    }


    // Simpan perubahan pengingat tagihan
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:enable,disable',
            'hari_sebelum' => 'required|integer|min:1|max:7',
            'waktu_kirim' => 'required|in:pagi,siang,malam',
            'template_pesan' => 'required|string|max:500'
        ]);

        try {
            $pengingat = PengingatTagihan::findOrFail($id);
            $pengingat->update($validated);

            return back()->with([
                'alert_type' => 'success',
                'alert_message' => 'Pengaturan berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating pengingat tagihan: ' . $e->getMessage());

            return back()->with([
                'alert_type' => 'error',
                'alert_message' => 'Gagal memperbarui pengaturan. Error: ' . $e->getMessage()
            ])->withInput();
        }
    }

    // Hapus pelanggan (opsional: pengingat juga)
    public function destroy($id)
    {
        try {
            $pelanggan = Pelanggan::findOrFail($id);
            $pelanggan->delete();

            return redirect()->route('admin.pengingat.index')
                ->with('success', 'Pelanggan berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus pelanggan');
        }
    }

    public function create()
    {
        $pelangganList = Pelanggan::all();
        $pengingat = new PengingatTagihan(); // Lebih baik diinisialisasi sebagai object baru

        return view('admin.pengaturan.pengingat-tagihan.create', compact('pelangganList', 'pengingat'));
    }

    // app/Http/Controllers/Admin/PengingatTagihanController.php

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'status' => 'required|in:aktif,nonaktif',
            'hari_sebelum' => 'required|integer|min:1|max:30',
            'waktu_kirim' => 'required|in:pagi,siang,malam',
            'template_pesan' => 'required|string|min:10|max:500'
        ]);

        DB::beginTransaction();

        try {
            $pelanggan = Pelanggan::findOrFail($validated['pelanggan_id']);

            // Hitung tanggal pengingat
            $tanggalPengingat = Carbon::parse($pelanggan->jatuh_tempo)
                ->subDays($validated['hari_sebelum']);

            // Mapping waktu kirim
            $waktuKirim = [
                'pagi' => '08:00:00',
                'siang' => '12:00:00',
                'malam' => '18:00:00'
            ][$validated['waktu_kirim']];

            $pengingat = PengingatTagihan::create([
                'pelanggan_id' => $pelanggan->id,
                'status' => $validated['status'],
                'hari_sebelum' => $validated['hari_sebelum'],
                'waktu_kirim' => $validated['waktu_kirim'],
                'template_pesan' => $validated['template_pesan'],
                'template_asli' => $validated['template_pesan'],
                'tanggal_pengingat' => $tanggalPengingat
            ]);

            // Jika aktif, jadwalkan notifikasi
            if ($validated['status'] === 'aktif') {
                $this->scheduleReminder($pengingat);
            }

            DB::commit();

            return redirect()
                ->route('admin.pengaturan.pengingat-tagihan.index')
                ->with('success', 'Pengingat berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Gagal menyimpan pengingat: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    private function scheduleReminder(PengingatTagihan $pengingat)
    {
        try {
            $reminderTime = Carbon::parse($pengingat->tanggal_pengingat->format('Y-m-d') . ' ' . $pengingat->waktu_kirim);

            // Pastikan notifikasi dijadwalkan di masa depan
            if ($reminderTime->isPast()) {
                $reminderTime->addDay();
            }

            // Kirim ke job queue
            KirimPengingatJob::dispatch($pengingat)
                ->delay($reminderTime);

            Log::info('Pengingat dijadwalkan untuk: ' . $reminderTime);
        } catch (\Exception $e) {
            Log::error('Gagal menjadwalkan: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        $pengingat = PengingatTagihan::findOrFail($id);
        $pengingat->status = !$pengingat->status;
        $pengingat->save();

        return redirect()->back()->with('success', 'Status berhasil diubah.');
    }
}
