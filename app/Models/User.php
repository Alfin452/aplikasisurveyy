<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'google_id',
        'role_id', // <-- DITAMBAHKAN
        'is_active', // <-- DITAMBAHKAN
        'email_verified', // <-- DITAMBAHKAN
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        // 'remember_token', // Jika Anda menggunakan fitur "remember me"
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified' => 'boolean',
        'is_active' => 'boolean',
        'password' => 'hashed', // Otomatis hash password saat di-set
    ];

    // --- RELASI ANDA SUDAH SEMPURNA ---

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
