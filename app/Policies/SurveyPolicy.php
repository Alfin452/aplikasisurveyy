<?php

namespace App\Policies;

use App\Models\Survey;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SurveyPolicy
{
    /**
     * Aturan ini berjalan sebelum aturan lainnya.
     * Jika pengguna adalah Superadmin (role_id 1), dia otomatis diizinkan melakukan apa saja.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role_id === 1) {
            return true;
        }

        return null; // Lanjutkan ke aturan lain jika bukan Superadmin
    }

    /**
     * Tentukan apakah pengguna dapat melihat survei.
     */
    public function view(User $user, Survey $survey): bool
    {
        return $survey->unitKerja()->where('unit_kerjas.id', $user->unit_kerja_id)->exists();
    }

    /**
     * Tentukan apakah pengguna dapat membuat survei.
     */
    public function create(User $user): bool
    {
        // Izinkan jika pengguna adalah Superadmin (sudah ditangani oleh 'before')
        // ATAU jika dia adalah Admin Unit Kerja.
        return $user->role_id === 2;
    }

    /**
     * Tentukan apakah pengguna dapat memperbarui survei.
     */
    public function update(User $user, Survey $survey): bool
    {
        return $survey->unitKerja()->where('unit_kerjas.id', $user->unit_kerja_id)->exists();
    }

    /**
     * Tentukan apakah pengguna dapat menghapus survei.
     */
    public function delete(User $user, Survey $survey): bool
    {
        return $survey->unitKerja()->where('unit_kerjas.id', $user->unit_kerja_id)->exists();
    }
}
