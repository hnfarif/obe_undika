<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumenMonev extends Model
{
    use HasFactory;

    protected $table = 'instrumen_monev';
    protected $guarded = ["id"];

    public function insNilai(){
        return $this->belongsTo(InstrumenNilai::class, 'ins_nilai_id', 'id');
    }

    public function plotMonev(){
        return $this->belongsTo(PlottingMonev::class, 'plot_monev_id', 'id');
    }

    public function detailMonev(){
        return $this->hasMany(DetailInstrumenMonev::class, 'ins_monev_id', 'id');
    }
}
