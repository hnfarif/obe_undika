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
        return $this->belongsToMany(Plo::class);
    }

    public function rps()
    {
        return $this->belongsTo(Rps::class);
    }

    public function penilaians()
    {
        return $this->belongsToMany(Penilaian::class);
    }

    public function llos()
    {
        return $this->belongsToMany(Llo::class);
    }
}
