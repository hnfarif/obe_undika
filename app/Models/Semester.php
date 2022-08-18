<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $table = 'semester_mf';
    protected $guarded = ['fak_id'];
    protected $primaryKey = false;
    public $incrementing = false;
}
