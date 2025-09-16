<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi: Satu pilihan jawaban dimiliki oleh satu pertanyaan
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // Relasi: Satu pilihan bisa dipilih di banyak jawaban
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
