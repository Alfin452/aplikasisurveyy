<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi: Satu pertanyaan dimiliki oleh satu survey
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    // Relasi: Satu pertanyaan memiliki banyak pilihan jawaban
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    // Relasi: Satu pertanyaan bisa memiliki banyak jawaban
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
