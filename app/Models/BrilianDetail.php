<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrilianDetail extends Model
{
    use HasFactory;

    protected $table = 'brilian_detail';
    protected $guarded = ['id'];

    public function brilian()
    {
        return $this->belongsTo(BrilianWeek::class, 'brilian_week_id', 'id');
    }
}
