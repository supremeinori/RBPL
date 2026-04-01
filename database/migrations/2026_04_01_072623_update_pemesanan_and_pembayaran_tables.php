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
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->bigInteger('total_harga')->nullable()->after('status_pemesanan');
            $table->string('bukti_kesepakatan')->nullable()->after('total_harga');
        });

        Schema::table('pembayaran', function (Blueprint $table) {
            $table->enum('jenis_pembayaran', ['dp', 'pelunasan'])->after('tanggal_bayar');
            $table->bigInteger('nominal')->after('jenis_pembayaran');
            $table->string('bukti_kesepakatan_harga')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropColumn(['jenis_pembayaran', 'nominal']);
            $table->string('bukti_kesepakatan_harga')->nullable(false)->change();
        });

        Schema::table('pemesanan', function (Blueprint $table) {
            $table->dropColumn(['total_harga', 'bukti_kesepakatan']);
        });
    }
};
