<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;


    protected $table = 'mhs_mf';


    public function krses()
    {
       return $this->hasMany(Krs::class, 'mhs_nim', 'nim');
    }
}
