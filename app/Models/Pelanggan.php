<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode_pelanggan',
        'nama',
        'no_telepon',
        'jenis_layanan',
        'harga',
        'jatuh_tempo'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'jatuh_tempo' => 'date',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    protected static function booted()
    {
        static::deleting(function ($pelanggan) {
            $pelanggan->transaksi()->delete();
        });
    }



    public function pengingatTagihan()
    {
        return $this->hasOne(PengingatTagihan::class);
    }
}
