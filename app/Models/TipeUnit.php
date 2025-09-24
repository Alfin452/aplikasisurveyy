<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeUnit extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tipe_units';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_tipe_unit',
    ];

    /**
     * Get the unitKerja for the TipeUnit.
     */
    public function unitKerja()
    {
        return $this->hasMany(UnitKerja::class, 'tipe_unit_id');
    }
}
