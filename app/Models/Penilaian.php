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

    public function clos()
    {
        return $this->belongsToMany(Clo::class, 'bbt_penilaian', 'penilaian_id', 'clo_id');
    }

    public function getBobot($penilaian,$clo)
    {
        $bobot = BobotPenilaian::where('penilaian_id',$penilaian)->where('clo_id',$clo)->first();

        return $bobot->bobot;
    }

    public function getTotalPenilaian($id)
    {
        $bbtNilai = BobotPenilaian::where('penilaian_id', $id)->get();
        $total = 0;
        foreach ($bbtNilai as $b){
            $total += $b->bobot;
        }
        return $total;
    }

}
