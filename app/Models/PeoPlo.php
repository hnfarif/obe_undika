<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeoPlo extends Model
{
    use HasFactory;

    protected $table = 'peo_plo';
    protected $guarded = ["id"];
    protected $primaryKey = 'id';
}
