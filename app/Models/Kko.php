<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kko extends Model
{
    use HasFactory;

    protected $table = 'kko';
    protected $guarded = ['id'];

    public function level()
    {
        return $this->belongsTo(LevelRanah::class, 'kode_level', 'kode_level');
    }

}
