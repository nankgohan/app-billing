<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Http\Controllers\Controller;


class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // app/Http/Controllers/TransaksiController.php

    public function index(Request $request)
    {
        // Membuat query dasar untuk model Transaksi
        $transaksiQuery = Transaksi::with('pelanggan'); // Relasi dengan pelanggan

        // Memeriksa jika ada filter jenis layanan yang dipilih
        if ($request->has('jenis_layanan') && $request->jenis_layanan != '') {
            $transaksiQuery->whereHas('pelanggan', function ($q) use ($request) {
                // Filter berdasarkan kolom jenis_layanan pada tabel pelanggan
                $q->where('jenis_layanan', $request->jenis_layanan);
            });
        }

        // Menambahkan pagination dan mengambil data transaksi
        $transaksi = $transaksiQuery->latest()->paginate(10);

        return view('admin.transaksi.index', compact('transaksi'));
    }

    public function transaksi()
    {
        $transaksi = Transaksi::with('pelanggan')->get(); // atau bisa juga paginate()

        return view('admin.transaksi.index', compact('transaksi'));
    }

    public function pembayaran()
    {
        // Menampilkan khusus pembayaran
        $transaksi = Transaksi::where('jenis', 'pembayaran')->get();
        return view('admin.transaksi.pembayaran', compact('transaksi'));
    }

    public function tagihan(Request $request)
    {
        // Ambil tagihan yang statusnya pending
        $tagihan = Transaksi::with('pelanggan') // Pastikan relasi pelanggan sudah didefinisikan
            ->where('status', 'pending') // Filter hanya yang statusnya pending
            ->get();

        return view('admin.tagihan.index', compact('tagihan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        return view('admin.transaksi.show', compact('transaksi'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



    public function sendWhatsApp(Transaksi $transaksi)
    {
        $transaksi->load('pelanggan');

        if ($transaksi->status === 'pending') {
            $transaksi->status = 'lunas';
            $transaksi->save();
        }

        $nama = $transaksi->pelanggan->nama;
        $kode = $transaksi->kode_transaksi;
        $total = number_format($transaksi->total, 0, ',', '.');
        $layanan = ucfirst($transaksi->pelanggan->jenis_layanan ?? 'Layanan');

        // Ambil jatuh tempo lama
        $jatuhTempoLama = $transaksi->pelanggan->jatuh_tempo
            ? Carbon::parse($transaksi->pelanggan->jatuh_tempo)
            : Carbon::now();

        // Tambahkan 1 bulan
        $jatuhTempoBaru = $jatuhTempoLama->copy()->addMonth();

        // Simpan tanggal jatuh tempo baru ke database
        $transaksi->pelanggan->jatuh_tempo = $jatuhTempoBaru;
        $transaksi->pelanggan->save();

        // Format pesan WhatsApp
        $message = "📢 *Konfirmasi Pembayaran*\n\n"
            . "👨🏻‍🦰 *Nama:* {$nama}\n"
            . "🆔 *Kode:* {$kode}\n"
            . "🌐 *Layanan:* {$layanan}\n"
            . "💰 *Total:* Rp {$total}\n"
            . "📆 *Masa Aktif Sampai:* " . $jatuhTempoBaru->format('d/m/Y') . "\n"
            . "✅ *Status:* LUNAS\n\n"
            . "🙏🏻 Terima kasih telah berlangganan, semoga usaha nya selalu lancar!";

        $encodedMessage = urlencode($message);
        $phone = $this->formatPhoneNumber($transaksi->pelanggan->no_telepon);
        $whatsappLink = "https://wa.me/{$phone}?text={$encodedMessage}";

        return redirect()
            ->route('admin.transaksi.index')
            ->with('success', 'Transaksi berhasil dikonfirmasi dan masa aktif diperpanjang.')
            ->with('whatsapp_link', $whatsappLink);
    }

    // Di TransaksiController
    public function sendWhatsAppTagihan(Transaksi $transaksi)
    {
        $transaksi->load('pelanggan');

        $message =
            "Halo {$transaksi->pelanggan->nama},\n\n"
            . "*PENGINGAT TAGIAHAN*. \n \n"
            . "Tagihan *({$transaksi->pelanggan->jenis_layanan})* Anda dengan kode *{$transaksi->kode_transaksi}* "
            . "senilai 💰 *Rp " . number_format($transaksi->total, 0, ',', '.') . "* "
            . "dengan jatuh tempo pada *" . \Carbon\Carbon::parse($transaksi->jatuh_tempo)->format('d-m-Y') . "*.\n\n"
            . "Mohon segera melakukan pembayaran untuk menghindari pemutusan layanan.\n\n"
            . "❗ Abaikan pesan ini jika Anda sudah melakukan pembayaran. Terima kasih!";

        // Enkode pesan untuk link WhatsApp
        $encodedMessage = urlencode($message);
        $phone = $this->formatPhoneNumber($transaksi->pelanggan->no_telepon); // Pastikan format nomor benar
        $whatsappLink = "https://wa.me/{$phone}?text={$encodedMessage}";

        return redirect()->away($whatsappLink);
    }

    private function formatPhoneNumber($phone)
    {
        // Ubah format nomor ke 62...
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (substr($phone, 0, 1) === '0') {
            return '62' . substr($phone, 1);
        }

        return $phone;
    }
}
