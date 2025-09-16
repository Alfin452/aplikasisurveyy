<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'unit_kerja';

    public function users()
    {
        return $this->hasMany(User::class, 'unit_kerja_id');
    }

    public function surveys()
    {
        return $this->belongsToMany(Survey::class, 'survey_unit_kerja');
    }

    public function children()
    {
        return $this->hasMany(UnitKerja::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(UnitKerja::class, 'parent_id');
    }
}
