<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'body'
    ];

    public function Answers() {
        return $this->hasMany('App\Answer');
    }
}
