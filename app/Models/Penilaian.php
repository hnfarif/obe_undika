<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;


    protected $table = 'penilaian';
    protected $guarded = ["id"];
    protected $primaryKey = 'id';

    public function rps()
    {
        return $this->belongsTo(Rps::class, 'rps_id', 'id');
    }

    public function detailAgendas()
    {
        return $this->hasMany(DetailAgenda::class);
    }


    public function getBobotPen($id, $clos)
    {
        $total = 0;

        foreach ($clos as $i) {
            $total += DetailAgenda::where('clo_id', $i->id)->where('penilaian_id', $id)->sum('bobot');
        }

        return $total;
    }

}
