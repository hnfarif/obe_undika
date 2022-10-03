<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bagian extends Model
{
    use HasFactory;

    protected $table = 'bagian1';


    public function karyawans()
    {
        return $this->hasMany(KaryawanDosen::class);
    }

}
