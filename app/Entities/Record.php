<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Record extends Model {
    protected $fillable = [
        'user_id',
        'doubleStudent_id',
        'petition_id',
        'petitionFirst'
    ];

    public function human() {
      return $this->belongsTo('App\Entities\Human');
    }

    public function petition() {
      return $this->belongsTo('App\Entities\Petition');
    }

    public function doubleStudent() {
      return $this->belongsTo('App\Entities\DoubleStudent');
    }
}
