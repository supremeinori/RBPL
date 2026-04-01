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
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->string('metode_pembayaran')->nullable()->after('jenis_pembayaran'); // misal Transfer bank, dll
            $table->unsignedBigInteger('id_validator')->nullable()->after('status_verifikasi'); 
            $table->dateTime('tanggal_validasi')->nullable()->after('id_validator');
            $table->text('alasan_penolakan')->nullable()->after('tanggal_validasi');

            $table->foreign('id_validator')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropForeign(['id_validator']);
            $table->dropColumn(['metode_pembayaran', 'id_validator', 'tanggal_validasi', 'alasan_penolakan']);
        });
    }
};
