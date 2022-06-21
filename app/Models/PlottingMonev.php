<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlottingMonev extends Model
{
    use HasFactory;

    protected $table = 'plotting_monev';
    protected $guarded = ["id"];
}
