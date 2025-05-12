<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            // Mengganti nama kolom 'telepon' menjadi 'no_telepon'
            $table->string('no_telepon', 15)->after('nama'); // Menambah kolom baru
            $table->dropColumn('telepon'); // Menghapus kolom lama
        });
    }

    public function down()
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            // Mengembalikan perubahan jika migrasi dibatalkan
            $table->string('telepon', 15)->after('nama'); // Menambah kolom 'telepon' lagi
            $table->dropColumn('no_telepon'); // Menghapus kolom 'no_telepon'
        });
    }
};
