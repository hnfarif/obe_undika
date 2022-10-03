<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanDosen extends Model
{
    use HasFactory;

    protected $table = 'kar_mf';



    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'fakul_id', 'id');
    }

    public function bagianKary()
    {
        return $this->belongsTo(Bagian::class, 'bagian', 'kode');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'nik', 'nik');
    }

    public function emailStaf()
    {
        return $this->hasOne(MailStaf::class, 'nik', 'nik');
    }

    public function rpses()
    {
        return $this->hasMany(Rps::class);
    }

    public function scopeProdi($query)
    {
        if (request()->prodi) {
            return $query->whereIn('fakul_id', request('prodi'));
        }
    }

    public function scopeFakultas($query)
    {
        if (request()->fakultas) {
            $prodi = Prodi::whereIn('id_fakultas', request()->fakultas)->pluck('id')->toArray();
            return $query->whereIn('fakul_id', $prodi);
        }
    }



}
