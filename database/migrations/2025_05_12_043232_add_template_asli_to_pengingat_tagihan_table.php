<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengingat_tagihan', function (Blueprint $table) {
            $table->text('template_asli')->after('template_pesan');
            $table->date('tanggal_pengingat')->after('waktu_kirim');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengingat_tagihan', function (Blueprint $table) {
            $table->dropColumn(['template_asli', 'tanggal_pengingat']);
        });
    }
};
