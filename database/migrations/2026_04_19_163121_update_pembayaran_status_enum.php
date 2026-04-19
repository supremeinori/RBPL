<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change existing data to match new enum
        DB::table('pembayaran')->where('status_verifikasi', 'disetujui')->update(['status_verifikasi' => 'pending']);
        DB::table('pembayaran')->where('status_verifikasi', 'ditolak')->update(['status_verifikasi' => 'pending']);

        // Since renaming enums requires some trickery in Doctrine DBAL, passing through the alter statement is cleaner
        DB::statement("ALTER TABLE pembayaran MODIFY COLUMN status_verifikasi ENUM('pending', 'valid', 'tidak_valid') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First revert the data
        DB::table('pembayaran')->where('status_verifikasi', 'valid')->update(['status_verifikasi' => 'pending']);
        DB::table('pembayaran')->where('status_verifikasi', 'tidak_valid')->update(['status_verifikasi' => 'pending']);

        DB::statement("ALTER TABLE pembayaran MODIFY COLUMN status_verifikasi ENUM('pending', 'disetujui', 'ditolak') DEFAULT 'pending'");
    }
};
