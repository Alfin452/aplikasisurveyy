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
        // 1. Menambahkan kolom baru ke tabel 'surveys'
        Schema::table('surveys', function (Blueprint $table) {
            $table->boolean('requires_pre_survey')->default(false)->after('is_active');
        });

        // 2. Membuat tabel baru untuk menyimpan jawaban pra-survei
        Schema::create('pre_survey_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('full_name');
            $table->string('gender'); // e.g., 'Laki-laki', 'Perempuan'
            $table->integer('age');
            $table->string('status'); // e.g., 'Mahasiswa', 'Dosen', 'Tendik'
            $table->string('unit_kerja_or_fakultas');
            $table->timestamps();

            // Menambahkan unique constraint untuk memastikan satu user hanya bisa mengisi satu kali per survei
            $table->unique(['survey_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_survey_responses');

        Schema::table('surveys', function (Blueprint $table) {
            $table->dropColumn('requires_pre_survey');
        });
    }
};
