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
        Schema::table('survey_programs', function (Blueprint $table) {
            // Menambahkan kolom tanggal setelah 'description'
            $table->date('start_date')->nullable()->after('description');
            $table->date('end_date')->nullable()->after('start_date');

            // Menambahkan kolom status setelah 'end_date'
            $table->boolean('is_active')->default(true)->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_programs', function (Blueprint $table) {
            // Menghapus ketiga kolom saat rollback
            $table->dropColumn(['start_date', 'end_date', 'is_active']);
        });
    }
};
