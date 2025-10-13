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
            // LANGKAH 1: Buat tabel 'survey_programs' (Wadah)
            Schema::create('survey_programs', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('alias')->unique()->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });

            // LANGKAH 2: Buat tabel pivot untuk menghubungkan 'survey_programs' dengan 'unit_kerjas' (Target)
            Schema::create('survey_program_unit_kerja', function (Blueprint $table) {
                $table->foreignId('survey_program_id')->constrained('survey_programs')->onDelete('cascade');
                $table->foreignId('unit_kerja_id')->constrained('unit_kerjas')->onDelete('cascade');
                $table->primary(['survey_program_id', 'unit_kerja_id']);
            });

            // LANGKAH 3: Modifikasi tabel 'surveys' (menjadi Turunan/Pelaksanaan)
            Schema::table('surveys', function (Blueprint $table) {
                // Menambahkan foreign key ke 'survey_programs'
                $table->foreignId('survey_program_id')->nullable()->after('id')->constrained('survey_programs')->onDelete('cascade');
                
                // Menambahkan foreign key ke 'unit_kerjas' untuk menandakan pemilik survei turunan ini
                $table->foreignId('unit_kerja_id')->nullable()->after('survey_program_id')->constrained('unit_kerjas')->onDelete('cascade');
            });

            // LANGKAH 4: Hapus tabel pivot 'survey_unit_kerja' yang lama
            Schema::dropIfExists('survey_unit_kerja');
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            // Urutan dibalik untuk rollback yang aman

            // LANGKAH 1 (Rollback): Buat kembali tabel 'survey_unit_kerja' yang lama
            Schema::create('survey_unit_kerja', function (Blueprint $table) {
                $table->foreignId('survey_id')->constrained('surveys')->onDelete('cascade');
                $table->foreignId('unit_kerja_id')->constrained('unit_kerjas')->onDelete('cascade');
                $table->primary(['survey_id', 'unit_kerja_id']);
            });

            // LANGKAH 2 (Rollback): Hapus kolom baru dari tabel 'surveys'
            Schema::table('surveys', function (Blueprint $table) {
                $table->dropForeign(['survey_program_id']);
                $table->dropForeign(['unit_kerja_id']);
                $table->dropColumn(['survey_program_id', 'unit_kerja_id']);
            });

            // LANGKAH 3 (Rollback): Hapus tabel pivot baru
            Schema::dropIfExists('survey_program_unit_kerja');

            // LANGKAH 4 (Rollback): Hapus tabel 'survey_programs'
            Schema::dropIfExists('survey_programs');
        }
    };