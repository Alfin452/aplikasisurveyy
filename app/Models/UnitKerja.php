<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class UnitKerja extends Model
{
    use HasFactory;

    protected $table = 'unit_kerjas';

    protected $fillable = [
        'unit_kerja_name',
        'uk_short_name',
        'tipe_unit_id',
        'parent_id',
        'contact',
        'address',
        'start_time',
        'end_time',
    ];

    public function tipeUnit()
    {
        return $this->belongsTo(TipeUnit::class, 'tipe_unit_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'unit_kerja_id');
    }

    public function surveys()
    {
        return $this->belongsToMany(Survey::class, 'survey_unit_kerjas');
    }

    public function children()
    {
        return $this->hasMany(UnitKerja::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(UnitKerja::class, 'parent_id');
    }

    /**
     * Scope a query to only include filtered results.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('unit_kerja_name', 'like', '%' . $search . '%');
        });

        $query->when($filters['type'] ?? false, function ($query, $type) {
            return $query->where('tipe_unit_id', $type);
        });

        // DITAMBAHKAN: Logika untuk filter berdasarkan parent_id
        $query->when($filters['parent'] ?? false, function ($query, $parent) {
            return $query->where('parent_id', $parent);
        });

        return $query;
    }
}
