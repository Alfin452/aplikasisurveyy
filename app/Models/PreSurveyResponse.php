<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreSurveyResponse extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'survey_id',
        'user_id',
        'full_name',
        'gender',
        'age',
        'status',
        'unit_kerja_or_fakultas',
    ];

    /**
     * Get the survey that this response belongs to.
     */
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    /**
     * Get the user that this response belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
