<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder; // <-- DITAMBAHKAN
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
        'role_id',
        'unit_kerja_id', // <-- DITAMBAHKAN
        'is_active',
        'email_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified' => 'boolean',
        'is_active' => 'boolean',
        'password' => 'hashed',
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

    /**
     * DITAMBAHKAN: Local Scope untuk menangani semua logika filter.
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        // Filter berdasarkan pencarian nama atau email
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('username', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        });

        // Filter berdasarkan peran (role)
        $query->when($filters['role'] ?? false, function ($query, $roleId) {
            return $query->where('role_id', $roleId);
        });

        // Filter berdasarkan unit kerja
        $query->when($filters['unit_kerja'] ?? false, function ($query, $unitKerjaId) {
            return $query->where('unit_kerja_id', $unitKerjaId);
        });

        return $query;
    }
}
