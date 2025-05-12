<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisLayanan extends Model
{
    use HasFactory;

    protected $table = 'jenis_layanan'; // Sesuaikan dengan nama tabel

    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class, 'jenis_layanan_id');
    }
}
