<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'kurlkl_mf';
    public $primaryKey = 'id';
    public $incrementing = false;


    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'fakul_id', 'id');
    }

    public function rps()
    {
        return $this->hasOne(Rps::class);
    }

    public function getProdiName($id)
    {
        $n = Prodi::find($id);
        return $n->nama;
    }
}
