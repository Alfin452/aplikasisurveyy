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
     * Relasi many-to-many dengan model UnitKerja.
     * Satu survei dapat ditargetkan ke banyak unit kerja.
     */
    public function unitKerja()
    {
        return $this->belongsToMany(UnitKerja::class, 'survey_unit_kerja');
    }

    /**
     * Relasi one-to-many ke model Question.
     * Survei memiliki banyak pertanyaan.
     */
    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('order_column', 'asc');
    }

    /**
     * Relasi one-to-many ke model Answer.
     * Survei memiliki banyak jawaban.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Scope untuk memfilter survei berdasarkan kriteria tertentu.
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        });

        $query->when(isset($filters['status']) && $filters['status'] !== '', function ($query) use ($filters) {
            return $query->where('is_active', $filters['status']);
        });

        $query->when($filters['unit_kerja'] ?? false, function ($query, $unitKerjaId) {
            return $query->whereHas('unitKerja', function ($q) use ($unitKerjaId) {
                $q->where('unit_kerjas.id', $unitKerjaId);
            });
        });

        $query->when($filters['year'] ?? false, function ($query, $year) {
            return $query->whereYear('start_date', $year);
        });

        return $query;
    }
}
