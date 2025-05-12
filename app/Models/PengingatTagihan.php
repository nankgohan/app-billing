<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengingatTagihan extends Model
{
    use HasFactory;

    protected $table = 'pengingat_tagihan';
    protected $fillable = [
        'pelanggan_id',
        'status',
        'hari_sebelum',
        'waktu_kirim',
        'template_pesan',
        'template_asli',
        'jatuh_tempo',
        'tanggal_pengingat',
    ];

    protected $casts = [
        'tanggal_pengingat' => 'date',
        'hari_sebelum' => 'integer',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class)->withDefault([
            'nama' => 'Pelanggan Tidak Dikenal',
            'jatuh_tempo' => now()->addMonth()
        ]);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
