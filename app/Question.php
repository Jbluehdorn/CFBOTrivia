<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'body', 'form_id'
    ];

    protected $with = ['answers'];

    public function answers() {
        return $this->hasMany('App\Answer');
    }
}
