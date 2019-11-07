<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Record extends Model {
    protected $fillable = [
        'student_id',
        'doubleStudent_id',
        'petition_id',
        'petitionFirst'
    ];

    public function student() {
      return $this->hasMany('App\User');
    }

    public function petition() {
      return $this->morphToMany('App\Entities\Petition', 'taggable');
    }

    public function doubleStudent() {
      return $this->morphToMany('App\Entities\DoubleStudent', 'taggable');
    }
}
