<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Llo extends Model
{
    use HasFactory;

    protected $table = 'llo';
    protected $guarded = ["id"];
    protected $primaryKey = 'id';

    public function clos()
    {
        return $this->belongsToMany(Clo::class, 'clo_llo', 'clo_id', 'llo_id');
    }

    public function agendabelajars()
    {
        return $this->belongsToMany(AgendaBelajar::class, 'map_llo_agd', 'llo_id', 'agd_id');
    }
}
