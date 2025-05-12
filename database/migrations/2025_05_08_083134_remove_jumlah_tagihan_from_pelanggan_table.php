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
            // Hanya hapus kolom jika ada
            if (Schema::hasColumn('pelanggan', 'jumlah_tagihan')) {
                $table->dropColumn('jumlah_tagihan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->decimal('jumlah_tagihan', 12, 2)->default(0);
        });
    }
};
