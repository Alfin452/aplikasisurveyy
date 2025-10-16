<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'is_active',
        'is_template',
        'requires_pre_survey',
        'is_global_template',
        'survey_program_id', // DITAMBAHKAN: Untuk mengikat ke "Wadah"
        'unit_kerja_id',     // DITAMBAHKAN: Untuk menandakan pemilik "Turunan"
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'is_template' => 'boolean',
        'requires_pre_survey' => 'boolean',
        'is_global_template' => 'boolean',
    ];

    /**
     * DITAMBAHKAN: Relasi ke "Wadah" (SurveyProgram).
     * Setiap survei pelaksanaan adalah bagian dari satu program.
     */
    public function surveyProgram()
    {
        return $this->belongsTo(SurveyProgram::class);
    }

    /**
     * DIUBAH: Relasi ke UnitKerja sekarang menjadi belongsTo.
     * Setiap survei pelaksanaan dimiliki oleh satu unit kerja.
     */
    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('order_column', 'asc');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        });

        $query->when(isset($filters['status']) && $filters['status'] !== '', function ($query) use ($filters) {
            return $query->where('is_active', $filters['status']);
        });

        // DIUBAH: Logika filter disederhanakan karena relasi menjadi langsung
        $query->when($filters['unit_kerja'] ?? false, function ($query, $unitKerjaId) {
            return $query->where('unit_kerja_id', $unitKerjaId);
        });

        $query->when($filters['year'] ?? false, function ($query, $year) {
            return $query->whereYear('start_date', $year);
        });

        return $query;
    }
}
