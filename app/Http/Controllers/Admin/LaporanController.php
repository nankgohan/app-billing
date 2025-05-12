<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function harian()
    {


        $tanggal = request('tanggal', now()->format('Y-m-d'));
        $transaksi = Transaksi::whereDate('tanggal', $tanggal)->get();
        return view('admin.laporan.harian', compact('transaksi', 'tanggal'));
    }

    public function bulanan()
    {
        $bulan = request('bulan', now()->format('Y-m'));
        $transaksi = Transaksi::whereMonth('tanggal', date('m', strtotime($bulan)))
            ->whereYear('tanggal', date('Y', strtotime($bulan)))
            ->get();
        return view('admin.laporan.bulanan', compact('transaksi', 'bulan'));
    }


    public function index()
    {
        //
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
    public function show(string $id)
    {
        //
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
}
