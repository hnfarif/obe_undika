<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AngketTrans extends Model
{
    use HasFactory;

    protected $table = 'angket_tf';
    protected $guarded = ["nik"];
    public $incrementing = false;
    protected $primaryKey = null;
}
