<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaBelajar extends Model
{
    use HasFactory;

    protected $table = 'agd_bljr';
    protected $guarded = ["id"];
    protected $primaryKey = 'id';

    public function rps()
    {
        return $this->belongsTo(Rps::class, 'rps_id', 'id');
    }

    public function detailAgendas()
    {
        return $this->hasMany(DetailAgenda::class, 'agd_id', 'id');
    }

    public function getTglNilaiAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }
}
