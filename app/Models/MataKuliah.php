<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'kurlkl_mf';
    protected $guarded = [];
    protected $primaryKey = 'id';

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
