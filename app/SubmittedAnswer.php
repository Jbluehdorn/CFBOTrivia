<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Question;

class SubmittedAnswer extends Model
{
    protected $with = ['user'];

    public function User() {
        return $this->belongsTo('App\User');
    }

    public function Question() {
        return $this->belongsTo('App\Question');
    }

    public function Grade() {
        $question = Question::find($this->question_id);

        foreach($question->answers as $answer) {
            if(strtolower(trim($answer->body)) == strtolower(trim($this->body))) {
                $this->correct = true;
                $this->save();
            }
        }
    }
}
