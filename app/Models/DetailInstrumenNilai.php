<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailInstrumenNilai extends Model
{
    use HasFactory;

    protected $table = 'dtl_ins_nilai';
    protected $guarded = ["id"];
    protected $with = ['insNilai', 'detailAgenda'];

    public function insNilai()
    {
        return $this->belongsTo(InstrumenNilai::class, 'ins_nilai_id', 'id');
    }

    public function detailAgenda()
    {
        return $this->belongsTo(DetailAgenda::class, 'dtl_agd_id', 'id');
    }

}
