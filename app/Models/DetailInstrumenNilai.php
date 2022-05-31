<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailInstrumenNilai extends Model
{
    use HasFactory;

    protected $table = 'dtl_ins_nilai';
    protected $guarded = ["id"];

    public function insNilai()
    {
        return $this->hasMany(InstrumenNilai::class);
    }

    public function detailAgenda()
    {
        return $this->belongsTo(DetailAgenda::class, 'dtl_agd_id', 'id');
    }

}
