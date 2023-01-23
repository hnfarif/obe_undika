<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBap extends Model
{
    use HasFactory;

    protected $table = 'detail_berita';

    public function convertDate($date)
    {
        $con = Carbon::parse($date)->format('d-m-Y');
        return $con;
    }
}
