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
        // 🔻 HAPUS dari pemesanan
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->dropColumn('file_referensi');
        });

        // 🔻 TAMBAH ke desain
        Schema::table('desain', function (Blueprint $table) {
            $table->string('file_referensi')->nullable()->after('file_desain');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // rollback

        Schema::table('pemesanan', function (Blueprint $table) {
            $table->string('file_referensi')->nullable();
        });

        Schema::table('desain', function (Blueprint $table) {
            $table->dropColumn('file_referensi');
        });
    }
};
