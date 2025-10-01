<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Perintah untuk menambahkan kolom baru 'order_column' ke tabel 'questions'
        Schema::table('questions', function (Blueprint $table) {
            // Menambahkan kolom integer tanpa tanda (hanya angka positif)
            // Default 0, ditempatkan setelah kolom 'type' agar rapi
            $table->unsignedInteger('order_column')->default(0)->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // Perintah untuk menghapus kolom 'order_column' jika migrasi di-rollback
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('order_column');
        });
    }
};