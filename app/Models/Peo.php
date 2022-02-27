<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peo extends Model
{
    use HasFactory;

    protected $table = 'peo';
    protected $guarded = ["id"];
    protected $primaryKey = 'id';

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function plos()
    {
        return $this->belongsToMany(Plo::class, 'peo_plo', 'peo_id', 'plo_id');
    }
}
