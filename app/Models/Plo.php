<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plo extends Model
{
    use HasFactory;

    protected $table = 'plo';
    protected $guarded = ["id"];
    protected $primaryKey = 'id';

    public function peos()
    {
        return $this->belongsToMany(Peo::class);
    }

    public function clos()
    {
        return $this->belongsToMany(Clo::class, 'plo_clo', 'plo_id', 'clo_id');
    }
}
