<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriKuliah extends Model
{
    use HasFactory;


    protected $table = 'materi_kuliah';
    protected $guarded = ["id"];
    protected $primaryKey = 'id';


    public function detailAgenda()
    {
        return $this->belongsTo(DetailAgenda::class, 'dtl_agd_id', 'id');
    }
}
