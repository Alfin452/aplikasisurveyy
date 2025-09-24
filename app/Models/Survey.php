<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'is_active',
        'is_template',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'is_template' => 'boolean',
    ];

    // --- RELASI ANDA SUDAH SEMPURNA ---

    /**
     * The unitKerja that belong to the Survey.
     */
    public function unitKerja()
    {
        return $this->belongsToMany(UnitKerja::class, 'survey_unit_kerja');
    }

    /**
     * Get the questions for the survey.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get the answers for the survey.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
