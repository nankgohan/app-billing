<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('sumber')->default('admin')->after('status'); // admin / pelanggan
            $table->string('layanan')->nullable()->after('sumber');      // internet / vpn / dst
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            if (Schema::hasColumn('transaksi', 'sumber')) {
                $table->dropColumn('sumber');
            }

            if (Schema::hasColumn('transaksi', 'layanan')) {
                $table->dropColumn('layanan');
            }
        });
    }
};
