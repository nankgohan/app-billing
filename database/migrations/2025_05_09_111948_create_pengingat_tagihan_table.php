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
        Schema::create('pengingat_tagihan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelanggan_id'); // tambahkan ini
            $table->string('status', 10);
            $table->tinyInteger('hari_sebelum');
            $table->enum('waktu_kirim', ['pagi', 'siang', 'malam'])->default('pagi');
            $table->text('template_pesan')->nullable();
            $table->timestamps();

            $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengingat_tagihan');
    }
};
