<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question_id',
        'option_body',
        'option_score',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'option_score' => 'integer',
    ];

    // --- RELASI ANDA SUDAH SEMPURNA ---

    /**
     * Get the question that owns the option.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the answers for the option.
     * Catatan: Ini akan berfungsi jika tabel 'answers' memiliki foreign key 'option_id'.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
