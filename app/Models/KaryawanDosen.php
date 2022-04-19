<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanDosen extends Model
{
    use HasFactory;

    protected $table = 'kar_mf';
    protected $guarded = ['nik'];
    // protected $primaryKey = 'nik';


    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'fakul_id', 'id');
    }

    public function bagian()
    {
        return $this->belongsToMany(Bagian::class, 'bagian', 'kode');
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function rpses()
    {
        return $this->hasMany(Rps::class);
    }




}