<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengingatTagihan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengingatList = PengingatTagihan::with('pelanggan')->get();
        return view('admin.pengaturan.index', compact('pengingatList'));
    }

    public function destroy($id)
    {
        $pengingat = PengingatTagihan::findOrFail($id);
        $pengingat->delete();

        return redirect()->back()->with('success', 'Pengingat berhasil dihapus.');
    }

    public function otherSetting()
    {
        // Menampilkan halaman pengaturan lainnya
        return view('admin.pengaturan.other-setting');
    }
}
