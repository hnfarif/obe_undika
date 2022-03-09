<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PloClo extends Model
{
    use HasFactory;

    protected $table = 'plo_clo';
    protected $guarded = ["id"];
    protected $primaryKey = 'id';
}
