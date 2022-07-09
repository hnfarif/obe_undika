<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuliah extends Model
{
    use HasFactory;

    protected $table = 'kul_tf';
    public $incrementing = false;
    protected $primaryKey = null;
}
