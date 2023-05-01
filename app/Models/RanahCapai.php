<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RanahCapai extends Model
{
    use HasFactory;

    protected $table = 'ranah_capai';
    protected $guarded = ["id"];
    protected $with = ['level'];

    public function level()
    {
        return $this->hasMany(LevelRanah::class, 'kode_ranah', 'kode');
    }
}
