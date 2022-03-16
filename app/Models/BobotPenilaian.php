<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BobotPenilaian extends Model
{
    use HasFactory;

    protected $table = 'bbt_penilaian';
    protected $guarded = ["id"];
    protected $primaryKey = 'id';
}
