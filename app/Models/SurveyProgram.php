<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class SurveyProgram extends Model
    {
        use HasFactory;

        protected $fillable = [
            'title',
            'alias',
            'description',
        ];

        /**
         * Get the route key for the model.
         * Ini memberitahu Laravel untuk menggunakan kolom 'alias' untuk URL.
         */
        public function getRouteKeyName()
        {
            return 'alias';
        }

        /**
         * Relasi Many-to-Many ke UnitKerja (Unit Kerja yang ditargetkan oleh program ini).
         */
        public function targetedUnitKerjas()
        {
            return $this->belongsToMany(UnitKerja::class, 'survey_program_unit_kerja');
        }

        /**
         * Relasi One-to-Many ke Survey (Semua survei turunan/pelaksanaan di bawah program ini).
         */
        public function surveys()
        {
            return $this->hasMany(Survey::class);
        }
    }
