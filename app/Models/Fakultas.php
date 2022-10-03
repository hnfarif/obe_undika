<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;

    protected $table = 'fakultas';


    public function prodis()
    {
        return $this->hasMany(Prodi::class, 'id_fakultas', 'id');
    }

    public function getAvgMonevFakul($id)
    {
        $prodi = Prodi::where('id_fakultas', $id)->get();
        $sum = 0;
        $count = $prodi->count();
        foreach ($prodi as $p) {
            $sum += $p->getAvgMonev($p->id);
        }

        $njdw = new JadwalKuliah();

        $avg = $njdw->divnum($sum, $count);
        return number_format($avg, 2);
    }

    public function getAvgAngketFakul($id)
    {
        $prodi = Prodi::where('id_fakultas', $id)->get();
        $sum = 0;
        $count = $prodi->count();
        foreach ($prodi as $p) {
            $sum += $p->getAvgAngket($p->id);
        }
        $njdw = new JadwalKuliah();
        $avg = $njdw->divnum($sum, $count);
        return number_format($avg, 2);
    }
}
