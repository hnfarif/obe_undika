<?php

namespace App\Models;

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
}
