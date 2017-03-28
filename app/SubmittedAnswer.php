<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubmittedAnswer extends Model
{
    protected $with = ['user'];

    public function User() {
        return $this->belongsTo('App\User');
    }

    public function Question() {
        return $this->belongsTo('App\Question');
    }
}
