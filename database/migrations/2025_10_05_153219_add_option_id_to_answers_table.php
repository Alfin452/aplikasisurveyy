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
        Schema::table('answers', function (Blueprint $table) {
            // Menambahkan kolom 'option_id' setelah 'question_id'
            // Kolom ini akan terhubung ke tabel 'options'
            $table->foreignId('option_id')->nullable()->after('question_id')->constrained('options')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('answers', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu
            $table->dropForeign(['option_id']);
            // Kemudian hapus kolomnya
            $table->dropColumn('option_id');
        });
    }
};