<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'student_id',
        'doubleStudent_id',
        'petition_id',
        'petitionFirst'
    ];
}
