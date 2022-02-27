<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    public function agendabelajar()
    {
        return $this->belongsTo(AgendaBelajar::class, 'agd_id', 'id');
    }
}
