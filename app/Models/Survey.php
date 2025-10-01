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
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'is_template' => 'boolean',
    ];

    public function unitKerja()
    {
        return $this->belongsToMany(UnitKerja::class, 'survey_unit_kerja');
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

        $query->when($filters['unit_kerja'] ?? false, function ($query, $unitKerjaId) {
            return $query->whereHas('unitKerja', function ($q) use ($unitKerjaId) {
                $q->where('unit_kerjas.id', $unitKerjaId);
            });
        });

        // DIUBAH: Memfilter berdasarkan tahun dari 'start_date'
        $query->when($filters['year'] ?? false, function ($query, $year) {
            return $query->whereYear('start_date', $year);
        });

        return $query;
    }
}
