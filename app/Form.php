<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'title'
    ];

    public function Questions() {
        return $this->hasMany('App\Question');
    }
}
