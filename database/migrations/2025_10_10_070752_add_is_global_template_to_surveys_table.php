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
        Schema::table('surveys', function (Blueprint $table) {
            // Menambahkan kolom baru setelah kolom 'is_template'
            // Kolom ini akan bertipe boolean (true/false) dan secara default bernilai false.
            $table->boolean('is_global_template')->default(false)->after('is_template');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->dropColumn('is_global_template');
        });
    }
};