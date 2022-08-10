<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;

    protected $table = 'fakultas';
    protected $guarded = ["id"];
    protected $primaryKey = 'id';


    public function prodis()
    {
        return $this->hasMany(Prodi::class, 'id_fakultas', 'id');
    }
}
