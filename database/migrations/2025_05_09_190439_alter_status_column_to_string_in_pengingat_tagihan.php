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
            $table->string('status', 10)->change(); // Ubah dari integer ke string
        });
    }

    public function down()
    {
        Schema::table('pengingat_tagihan', function (Blueprint $table) {
            $table->boolean('status')->change(); // Kembalikan ke boolean jika rollback
        });
    }
};
