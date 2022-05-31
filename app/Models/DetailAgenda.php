<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailAgenda extends Model
{

    use HasFactory;

    protected $table = 'dtl_agd';
    protected $guarded = ["id"];
    protected $primaryKey = 'id';

    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class, 'penilaian_id', 'id');
    }

    public function agendaBelajar()
    {
        return $this->belongsTo(AgendaBelajar::class, 'agd_id', 'id');
    }

    public function clo()
    {
        return $this->belongsTo(Clo::class, 'clo_id', 'id');
    }

    public function llo()
    {
        return $this->belongsTo(Llo::class, 'llo_id', 'id');
    }

    public function materiKuliahs()
    {
        return $this->hasMany(MateriKuliah::class, 'dtl_agd_id', 'id');
    }

    public function detailInstrumenNilai(){
        return $this->hasMany(DetailInstrumenNilai::class, 'dtl_agd_id', 'id');
    }

}
