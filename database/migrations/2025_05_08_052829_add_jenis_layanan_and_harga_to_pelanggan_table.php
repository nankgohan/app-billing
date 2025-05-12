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
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'email']); // Hapus kolom yang tidak diperlukan
            $table->enum('jenis_layanan', ['Internet', 'VPN Voucher'])->default('Internet');
            $table->decimal('harga', 12, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->string('alamat')->nullable();
            $table->string('email')->nullable();
            $table->dropColumn(['jenis_layanan', 'harga']);
        });
    }
};
