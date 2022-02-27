<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaBelajar extends Model
{
    use HasFactory;

    protected $table = 'agd_bljr';
    protected $guarded = ["id"];
    protected $primaryKey = 'id';

    public function llos()
    {
        return $this->belongsToMany(Llo::class);
    }

    public function materis()
    {
        return $this->hasMany(Materi::class);
    }

    public function rps()
    {
        return $this->belongsTo(Rps::class, 'rps_id', 'id');
    }
}
