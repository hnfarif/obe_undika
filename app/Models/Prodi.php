<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'fak_mf';
    protected $guarded = [];
    protected $primaryKey = 'id';


    public function karyawans()
    {
        return $this->hasMany(KaryawanDosen::class);
    }

    public function matakuliahs()
    {
        return $this->hasMany(Matakuliah::class);
    }

    public function peos()
    {
        return $this->hasMany(Peo::class);
    }


}
