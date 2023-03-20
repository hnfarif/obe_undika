<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clo extends Model
{
    use HasFactory;

    protected $table = 'clo';
    protected $guarded = ["id"];


    public function plos()
    {
        return $this->belongsToMany(Plo::class, 'plo_clo', 'clo_id', 'plo_id');
    }

    public function rps()
    {
        return $this->belongsTo(Rps::class);
    }

    public function detailAgendas()
    {
        return $this->hasMany(DetailAgenda::class);
    }
    public function getBobotClo($id,$pens)
    {
        $total = 0;

        foreach ($pens as $i) {
            $total += DetailAgenda::where('clo_id', $id)->where('penilaian_id', $i->id)->sum('bobot');
        }

        return $total;
    }

}
