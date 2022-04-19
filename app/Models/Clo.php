<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clo extends Model
{
    use HasFactory;

    protected $table = 'clo';
    protected $guarded = ["id"];
    protected $primaryKey = 'id';


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

    // public function getLulusNilai($id)
    // {
    //     $ln =  Clo::where('id',$id)->first();

    //     return [
    //         'lulus' => $ln->tgt_lulus,
    //         'nilai' => $ln->nilai_min,
    //     ];
    // }

    // public function getTotalClo($id){

    //     $bbt = BobotPenilaian::where('clo_id',$id)->get();
    //     $total = 0;
    //     foreach ($bbt as $b){
    //         $total += $b->bobot;
    //     }
    //     return $total;
    // }


}
