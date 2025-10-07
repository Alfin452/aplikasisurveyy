<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder; // <-- DITAMBAHKAN

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
        'unit_kerja_id',
        'no_wa',
        'jenis_kelamin',
        'umur',
        'asal_responden',
        'jenis_responden',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- DITAMBAHKAN: LOCAL SCOPE UNTUK FILTER ---

    /**
     * Menerapkan filter ke kueri pengguna.
     * Method ini akan dipanggil secara otomatis saat kita menggunakan ->filter() di controller.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $filters
     * @return void
     */
    public function scopeFilter(Builder $query, array $filters)
    {
        // Filter berdasarkan pencarian (search)
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('username', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        });

        // Filter berdasarkan peran (role_id)
        $query->when($filters['role'] ?? false, function ($query, $role) {
            $query->where('role_id', $role);
        });
    }

    // --- AKHIR BAGIAN TAMBAHAN ---


    /**
     * Accessor untuk mengecek apakah user adalah Superadmin.
     */
    public function getIsSuperadminAttribute()
    {
        return $this->role_id === 1;
    }

    /**
     * Accessor untuk mengecek apakah user adalah Admin Unit Kerja.
     */
    public function getIsUnitkerjaAdminAttribute()
    {
        return $this->role_id === 2;
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    // Relasi ke Role (jika Anda memiliki model Role)
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
