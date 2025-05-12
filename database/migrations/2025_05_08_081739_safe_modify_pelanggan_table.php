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
            // Hanya hapus kolom jika ada
            if (Schema::hasColumn('pelanggan', 'alamat')) {
                $table->dropColumn('alamat');
            }

            if (Schema::hasColumn('pelanggan', 'email')) {
                $table->dropColumn('email');
            }

            // Tambahkan kolom baru
            if (!Schema::hasColumn('pelanggan', 'jenis_layanan')) {
                $table->enum('jenis_layanan', ['Internet', 'VPN Voucher'])->default('Internet');
            }

            if (!Schema::hasColumn('pelanggan', 'jumlah_tagihan')) {
                $table->decimal('jumlah_tagihan', 12, 2)->default(0);
            }

            if (!Schema::hasColumn('pelanggan', 'jatuh_tempo')) {
                $table->date('jatuh_tempo')->nullable();
            }
        });
    }

    public function down()
    {
        // Tidak perlu implementasi jika migrasi sebelumnya gagal
    }
};
