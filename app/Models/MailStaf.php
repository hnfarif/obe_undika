<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailStaf extends Model
{
    use HasFactory;

    protected $table = 'mail_staf';
    protected $guarded = ["nik"];
    protected $primaryKey = 'nik';

}
