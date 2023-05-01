<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelRanah extends Model
{
    use HasFactory;

    protected $table = 'level_ranah';
    protected $guarded = ['id'];
    protected $with = ['kko'];

    public function ranah()
    {
        return $this->belongsTo(RanahCapai::class, 'kode_ranah', 'kode');
    }

    public function kko()
    {
        return $this->hasMany(Kko::class, 'kode_level', 'kode_level');
    }
}
