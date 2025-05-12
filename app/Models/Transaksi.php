<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi'; // Nama tabel dalam bentuk singular

    protected $fillable = [
        'pelanggan_id',
        'kode_transaksi',
        'tanggal',
        'jenis',
        'total',
        'status',
        // 'jatuh_tempo'
    ];
    // protected $dates = ['jatuh_tempo']; // Jika ada kolom jatuh_tempo

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
}
