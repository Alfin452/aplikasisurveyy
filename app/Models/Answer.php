<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'survey_id',
        'question_id',
        'option_id',    // <-- Pastikan ini ada
        'answer_skor',  // <-- Dan ini juga ditambahkan
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'answer_skor' => 'integer',
    ];

    // Relasi: Satu jawaban dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Satu jawaban milik satu survey
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    // Relasi: Satu jawaban milik satu pertanyaan
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // Relasi option() dihapus karena tidak ada kolom option_id
}
