<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrilianWeek extends Model
{
    use HasFactory;

    protected $table = 'brilian_week';
    protected $guarded = ['id'];

}
