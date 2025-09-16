<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $guarded = [];

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

    // Relasi: Satu jawaban memilih satu opsi
    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
