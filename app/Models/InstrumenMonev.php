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
}
