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
        Schema::create('desain', function (Blueprint $table) {
            $table->id('id_desain');
            $table->unsignedBigInteger('id_pemesanan');
            $table->foreign('id_pemesanan')->references('id_pemesanan')->on('pemesanan')->onDelete('cascade');
            $table->string('file_desain'); // Menyimpan nama path gambar desain
            $table->enum('status_desain', ['pending', 'disetujui', 'revisi'])->default('pending');
            $table->longText('catatan_admin')->nullable(); // Menyimpan catatan admin jika desain ditolak atau perlu revisi
            $table->date('tanggal_upload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desain');
    }
};
