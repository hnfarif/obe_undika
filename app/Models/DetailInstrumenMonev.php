<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailInstrumenMonev extends Model
{
    use HasFactory;

    protected $table = 'dtl_ins_monev';
    protected $guarded = ["id"];

    public function instrumenMonev()
    {
        return $this->belongsTo(InstrumenMonev::class, 'ins_monev_id', 'id');
    }

    public function detailAgenda()
    {
        return $this->belongsTo(DetailAgenda::class, 'dtl_agd_id','id');
    }
}
