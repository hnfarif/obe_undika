<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaMonev extends Model
{
    use HasFactory;

    protected $table = 'kri_monev';
    protected $guarded = ['id'];

}
