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
        Schema::table('pengingat_tagihan', function (Blueprint $table) {
            // Ubah menjadi string jika ingin menyimpan nilai 'pagi', 'siang', 'malam'
            $table->string('waktu_kirim', 10)->change();

            // Atau ubah menjadi time jika ingin menyimpan format '08:00:00'
            // $table->time('waktu_kirim')->change();
        });
    }

    public function down()
    {
        Schema::table('pengingat_tagihan', function (Blueprint $table) {
            // Kembalikan ke tipe sebelumnya jika diperlukan
            $table->time('waktu_kirim')->change();
        });
    }
};
