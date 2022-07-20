<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailInstrumenMonev extends Model
{
    use HasFactory;

    protected $table = 'dtl_ins_monev';
    protected $guarded = ["id"];
}
