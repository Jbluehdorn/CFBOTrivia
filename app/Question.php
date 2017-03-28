<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'body', 'form_id'
    ];

    protected $with = ['answers', 'submittedAnswers'];

    public function answers() {
        return $this->hasMany('App\Answer');
    }

    public function submittedAnswers() {
        return $this->hasMany('App\SubmittedAnswer');
    }
}
