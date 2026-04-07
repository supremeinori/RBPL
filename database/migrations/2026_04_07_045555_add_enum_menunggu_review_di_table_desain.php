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
        Schema::table('desain', function (Blueprint $table) {
            $table->enum('status_desain', ['baru', 'waiting_review', 'revisi', 'setuju'])->default('baru')->after('draft_ke')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('desain', function (Blueprint $table) {
            $table->dropColumn('status_desain' , ['baru', 'revisi', 'setuju'])->change();
        });
    }
};
    