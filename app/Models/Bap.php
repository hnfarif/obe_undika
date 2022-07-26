<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bap extends Model
{
    use HasFactory;

    protected $table = 'berita_acara';
    protected $guarded = ["kode_bap"];
    public $incrementing = false;
    protected $primaryKey = null;

}
